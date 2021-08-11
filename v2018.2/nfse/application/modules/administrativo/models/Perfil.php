<?php

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

/**
 * Class Administrativo_Model_Perfil
 *
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */

class Administrativo_Model_Perfil extends E2Tecnologia_Model_Doctrine {

  static protected $entityName = "Administrativo\Perfil";
  static protected $className = __CLASS__;

  /**
   *
   * @return \Administrativo_Model_Acao[]
   */
  public function getAcoes() {

    $r = array();

    foreach($this->entity->getAcoes() as $a) {
        $r[] = new Administrativo_Model_Acao($a);
    }
    return $r;
  }

  public function getPerfis() {

    $result = $this->entity->getPerfis();

    $retorno = array();
    foreach($result as $r) {
        $retorno[] = new Administrativo_Model_Perfil($r);
    }

    return $retorno;
  }

  /**
   * Trata os dados do formulário para serem salvos no banco de dados
   *
   * @param array $a
   * @return $this
   */
  public function persist(array $a) {

    $valid = $this->isValid($a);

    if ($valid['valid']) {

      /* seta atributos para serem salvos no banco.
       * Habilitado sempre inicia como true */

      if (isset($a['nome'])) {
        $this->entity->setNome($a['nome']);
      }

      if (isset($a['administrativo'])) {
        $this->entity->setAdministrativo($a['administrativo']);
      }

      if (isset($a['tipo'])) {
        $this->entity->setTipo($a['tipo']);
      }

      if ($this->getId() === null) {

        $acoes     = $this->getAcoes();
        $acoes_adm = array();

        foreach ($acoes as $a) {

          if (strtolower($a->getControle()->getModulo()->getNome()) == 'administrativo') {

            $acoes_adm[] = $a;
          }
        }

        $this->adicionaAcoes($acoes_adm);
      }

      $this->em->persist($this->entity);
      $this->em->flush();

      return $this;
    } else {

      return $valid['errors'];
    }
  }

  public function adicionaAcoes(array $acoes) {

    foreach ($acoes as $a) {
      $this->addAcao($a->getEntity());
    }

    $this->em->flush();
  }

  /**
   * Remove todas as a��es permitidas para o Usuario
   */
  public function limparAcoes() {

    foreach ($this->entity->getAcoes() as $a) {
        $this->delAcao($a);
    }
    $this->em->flush();
  }

  /**
   * Adiciona perfis para o perfil poder cadastrar
   *
   * @param array $aPerfis
   */
  public function adicionaPerfis(array $aPerfis) {

    foreach ($aPerfis as $aPerfil) {
      $this->addPerfis($aPerfil->getEntity());
    }

    $this->em->flush();
  }

  /**
   * Remove todas os perfis do perfil permitidas para o cadastro
   */
  public function limparPerfis() {

    foreach ($this->entity->getPerfis() as $aPerfil) {
      $this->delPerfis($aPerfil);
    }

    $this->em->flush();
  }

  /**
   * Valida campos do modelo. Retorna um vetor com dois campos
   * <b>valid:</b> booleano indicando se os atributos são válidos ou não
   * <b>errors:</b> array com os campos inválidos e as mensagens de erro
   * @param array $attrs
   * @return array
   */
  private function isValid(array $attrs) {
    return array('valid' => true, 'errors' => array());
  }
}