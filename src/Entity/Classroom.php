<?php

namespace App\Entity;

use App\Repository\ClassroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassroomRepository::class)]
class Classroom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'classroom')]
    private ?Subject $subject = null;

    #[ORM\OneToMany(mappedBy: 'classroom', targetEntity: TeacherTask::class)]
    private Collection $teacherTasks;

    #[ORM\OneToMany(mappedBy: 'classroom', targetEntity: Student::class)]
    private Collection $students;

    public function __construct()
    {
        $this->teacherTasks = new ArrayCollection();
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return Collection<int, TeacherTask>
     */
    public function getTeacherTasks(): Collection
    {
        return $this->teacherTasks;
    }

    public function addTeacherTask(TeacherTask $teacherTask): self
    {
        if (!$this->teacherTasks->contains($teacherTask)) {
            $this->teacherTasks->add($teacherTask);
            $teacherTask->setClassroom($this);
        }

        return $this;
    }

    public function removeTeacherTask(TeacherTask $teacherTask): self
    {
        if ($this->teacherTasks->removeElement($teacherTask)) {
            // set the owning side to null (unless already changed)
            if ($teacherTask->getClassroom() === $this) {
                $teacherTask->setClassroom(null);
            }
        }

        return $this;
    }
    
    public function __toString() {
        return $this->name;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setClassroom($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getClassroom() === $this) {
                $student->setClassroom(null);
            }
        }

        return $this;
    }
}
