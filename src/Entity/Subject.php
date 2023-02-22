<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'subject', targetEntity: Classroom::class)]
    private Collection $classroom;

    #[ORM\OneToMany(mappedBy: 'subject', targetEntity: Grade::class)]
    private Collection $grade;

    #[ORM\OneToMany(mappedBy: 'subject', targetEntity: Task::class)]
    private Collection $tasks;

    #[ORM\OneToMany(mappedBy: 'subject', targetEntity: TeacherTask::class)]
    private Collection $teacherTasks;

    public function __construct()
    {
        $this->classroom = new ArrayCollection();
        $this->grade = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->teacherTasks = new ArrayCollection();
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

    /**
     * @return Collection<int, Classroom>
     */
    public function getClassroom(): Collection
    {
        return $this->classroom;
    }

    public function addClassroom(Classroom $classroom): self
    {
        if (!$this->classroom->contains($classroom)) {
            $this->classroom->add($classroom);
            $classroom->setSubject($this);
        }

        return $this;
    }

    public function removeClassroom(Classroom $classroom): self
    {
        if ($this->classroom->removeElement($classroom)) {
            // set the owning side to null (unless already changed)
            if ($classroom->getSubject() === $this) {
                $classroom->setSubject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Grade>
     */
    public function getGrade(): Collection
    {
        return $this->grade;
    }

    public function addGrade(Grade $grade): self
    {
        if (!$this->grade->contains($grade)) {
            $this->grade->add($grade);
            $grade->setSubject($this);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        if ($this->grade->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getSubject() === $this) {
                $grade->setSubject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setSubject($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getSubject() === $this) {
                $task->setSubject(null);
            }
        }

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
            $teacherTask->setSubject($this);
        }

        return $this;
    }

    public function removeTeacherTask(TeacherTask $teacherTask): self
    {
        if ($this->teacherTasks->removeElement($teacherTask)) {
            // set the owning side to null (unless already changed)
            if ($teacherTask->getSubject() === $this) {
                $teacherTask->setSubject(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
    
}
