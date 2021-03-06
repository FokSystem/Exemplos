<?php

namespace controllers;

use application\Controller;
use application\Session;
use application\LogUso;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Diploma
 *
 * @author sam
 */
class Diploma extends Controller {

    //put your code here
    private $matricula;
    private $nota;

    public function __construct() {
         Session::nivelRestrito(array("administrador"));
        $this->matricula = $this->LoadModelo("Matricula");
        $this->nota = $this->LoadModelo("Nota");
        parent::__construct();
         $this->view->setJs(array("novo"));
         $this->view->setCss(array('amaran.min', 'animate.min', 'layout', 'ie'));
         $this->view->menu=  $this->getFooter('menu');
    }

    public function index($id = FALSE) {

        $this->view->dados = $this->nota->pesquisar();
        $this->view->renderizar("index");
    }

    public function gerar($id) {
        $d = $this->matricula->pesquisar($id);
        $css = "views/layout/default/bootstrap/css/bootstrap.min.css";
        $report = new \application\Diploma($css, 'sam');
        $report->setData($d->getData());
        $report->setNome($d->getAluno()->getPessoa()->getNome());
        $report->setModulo($d->getModulo()->getNome());
        $report->BuildPDF();
         $lo=new LogUso('log');
                $lo->verificarArquivo();
                $lo->gravar("Foi gerado um diploma".'  nome de aluno : '.$d->getAluno()->getPessoa()->getNome());
        $report->Exibir();
    }

}
