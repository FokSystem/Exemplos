<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use application\Dao;
use config\Doctrine;

/**
 * Docente
 *
 * @ORM\Table(name="docente", indexes={@ORM\Index(name="fk_docente_pessoa1_idx", columns={"pessoa_id"})})
 * @ORM\Entity
 */
class Docente extends Doctrine implements Dao {

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
     * @ORM\Column(name="grau", type="string", length=45, nullable=false)
     */
    private $grau;

    /**
     * @var \Pessoa
     *
     * @ORM\ManyToOne(targetEntity="Pessoa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     * })
     */
    private $pessoa;

    function getId() {
        return $this->id;
    }

    function getGrau() {
        return $this->grau;
    }

    function getPessoa() {
        return $this->pessoa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setGrau($grau) {
        $this->grau = $grau;
    }

    function setPessoa(Pessoa $pessoa) {
        $this->pessoa = $pessoa;
    }

    public function adiciona($dados, $id) {
        $pessoa = $this->em->getRepository('models\Pessoa')->findOneBy(array('id' => $id));
        $dados->setPessoa($pessoa);
        $this->em->persist($dados);
        $this->em->flush();
    }

    public function adicionar($dados = FALSE) {
        $editar = $this->em->getRepository('models\Docente')->findOneBy(array('pessoa' => $dados->getId()));
        $editar->setGrau($dados->getGrau());
        $this->em->flush();
        return TRUE;
    }

    public function editar($id = FALSE) {
        
    }

    public function pesquisaPor($dados = FALSE) {
        
    }

    public function pesquisar($id = FALSE) {

        if ($id) {
            return $this->em->getRepository('models\Docente')->findOneBy(array('pessoa' => $id));
            $this->em->flush();
        } else {
            return $this->em->getRepository('models\Docente')->findby(array(), array('id' => "DESC"));
            $this->em->flush();
        }
    }

    public function remover($id = FALSE) {
        $id = $this->em->getPartialReference('models\Pessoa', $id);
        $this->em->remove($id);
        $this->em->flush();
        return TRUE;
    }

    function listagem() {
        $qb = $this->em->createQueryBuilder()
                ->select('p.nome,d.id')
                ->from('models\Docente', 'd')
                ->innerJoin('models\Pessoa', 'p', 'WITH', 'd.pessoa=p.id')
                ->orderBy('d.id', 'DESC');
               
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
    
 


}