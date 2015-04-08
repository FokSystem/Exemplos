<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use application\Dao;
use config\Doctrine;

/**
 * Modulo
 *
 * @ORM\Table(name="modulo", indexes={@ORM\Index(name="fk_modulo_materia1_idx", columns={"materia_id"})})
 * @ORM\Entity
 */
class Modulo extends Doctrine implements Dao {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=30, nullable=false)
     */
    private $nome;

    /**
     * @var \Curso
     *
     * @ORM\ManyToOne(targetEntity="Curso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
     * })
     */
    private $curso;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getCurso() {
        return $this->curso;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setCurso(Curso $curso) {
        $this->curso = $curso;
    }

    public function adicionar($dados = FALSE) {
        
    }

    public function editar($id = FALSE) {
        
    }

    public function pesquisaPor($dados = FALSE) {
         if ($dados) {
            return $this->em->getRepository('models\Modulo')->findOneBy(array('id' => $dados));
            $this->em->flush();
        }
    }

    public function pesquisar($id = FALSE) {
        if ($id) {
            $qb = $this->em->createQueryBuilder()
                    ->select('e')
                    ->from('models\Modulo', 'e')
                    ->where('e.curso = ?1')
                    ->setParameter(1, $id);

            return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        } else {
            return $this->em->getRepository('models\Modulo')->findby(array(), array('id' => "DESC"));
            $this->em->flush();
        }
    }

    public function remover($id = FALSE) {
        
    }

    function listagem() {
        $t = $this->em->getRepository('models\Modulo');
        $qb = $t->createQueryBuilder('e');
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}