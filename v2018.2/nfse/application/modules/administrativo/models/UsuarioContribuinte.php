<?php
/*
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

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe responsável pela Manipulação dos Contribuintes vinculados ao Usuário
 * @author dbseller
 * @package Administrativo\Models\UsuarioContribuinte
 */
class Administrativo_Model_UsuarioContribuinte extends Administrativo_Lib_Model_Doctrine {

  static protected $entityName = "Administrativo\UsuarioContribuinte";
  static protected $className = __CLASS__;

  /**
   * Contribuintes com inscrição municipal;
   * @var integer
   */
  const CONTRIBUINTE_MUNICIPAL = 1;

  /**
   * Contribuintes fora do municipio ou contribuintes eventuais
   * @var integer
   */
  const CONTRIBUINTE_EVENTUAL = 2;

  /**
   * @param Administrativo_Model_Usuario $usuario
   * @param integer $contribuinte
   * @return Administrativo_Model_UsuarioContribuinte[]
   */
  public static function getByUsuarioContribuinte($usuario, $contribuinte) {

    $qb = parent::getEm()->createQueryBuilder();

    $qb->select('uc')
       ->from(self::$entityName, 'uc')
       ->where('1=1');

    if ($usuario !== null) {

      $qb->andWhere('uc.usuario = :u');
      $qb->setParameter('u', $usuario->getEntity());
    }

    if ($contribuinte !== null) {

      $qb->andWhere('uc.im = :c');
      $qb->setParameter('c', $contribuinte);
    }

    $a = array();

    foreach ($qb->getQuery()->getResult() as $r) {
      $a[] = new Administrativo_Model_UsuarioContribuinte($r);
    }

    return $a;
  }

  /**
   * Persiste os dados do usuario contribuinte
   * @param array $attrs
   * @return Administrativo_Model_UsuarioContribuinte
   */
  public function persist(array $attrs = null) {

    if (is_array($attrs)) {

      $valid = $this->isValid($attrs);

      if ($valid['valid']) {

        $this->entity->setUsuario($attrs['usuario']->getEntity());
        $this->entity->setIm($attrs['contribuinte']);
        $this->entity->setCnpjCpf($attrs['cnpj_cpf']);
        $this->entity->setTipoEmissao($attrs['tipo_emissao']);
        $this->entity->setTipoContribuinte($attrs['tipo_contribuinte']);
        $this->entity->setCgm($attrs['cgm']);
        $this->entity->setHabilitado(true);
      }
    }

    $this->em->persist($this->entity);
    $this->em->flush();

    return $this;
  }

  /**
   * Remove o Contribuinte do Usuário
   */
  public function remove() {

    $this->em->remove($this->entity);
    $this->em->flush();
  }

  /**
   * Remove todas as ações permitidas para o UsuarioContribuinte
   */
  public function limparAcoes($lGeradorDados = FALSE) {

    foreach ($this->entity->getUsuarioContribuinteAcoes() as $aAcao) {

      if ($lGeradorDados && !$aAcao->getAcao()->getGeradorDados()) {
        continue;
      }

      $this->em->remove($aAcao);
    }

    $this->em->flush();
  }

  /**
   * Retorna todas as ações permitidas para est UsuarioContribuinte
   * @param null $modulo
   * @param null $controle
   *
   * @return Administrativo_Model_Acao[]
   */
  public function getAcoes($modulo = null, $controle = null) {

    $uca = $this->getUsuarioContribuinteAcoes();
    $a = array();

    foreach ($uca as $i) {

      $acao = $i->getAcao();

      if (($controle === null || strtolower($acao->getControle()->getNome()) === $controle) &&
            ($modulo === null || strtolower($acao->getControle()->getModulo()->getNome()) === $modulo)) {

        $a[] = new Administrativo_Model_Acao($acao);
      }
    }

    return $a;
  }

  /**
   * Retorna os Usuários
   * @return Administrativo_Model_Usuario
   */
  public function getUsuario() {
    return new Administrativo_Model_Usuario($this->entity->getUsuario());
  }

  /**
   * Vincula vetor de acao ao UsuarioContribuinte
   * @param Administrativo_Model_Acao[] $acoes
   *
   * @throws Exception
   */
  public function adicionaAcoes(array $aAcoesNovasEnvio) {

    if (count($aAcoesNovasEnvio) <= 0) {
      throw new Exception('Parametro de ações não informado corretamente.');
    }

    $aContribuintesAcoes = $this->getEntity()->getUsuarioContribuinteAcoes();
    $aAcoesAntigas = array();
    $aAcoesNovas   = array();

    if (count($aContribuintesAcoes) > 0) {

      foreach ($aContribuintesAcoes as $oAcao) {
        $aAcoesAntigas[$oAcao->getAcao()->getId()] = $oAcao->getAcao()->getId();
      }
    }

    foreach ($aAcoesNovasEnvio as $oAcaoNova) {
      $aAcoesNovas[$oAcaoNova->getId()] = $oAcaoNova->getId();
    }

    if (count($aAcoesAntigas) > 0) {
      $aAcoesAdicionar = array_diff($aAcoesNovas, $aAcoesAntigas);
    } else {
      $aAcoesAdicionar = $aAcoesNovas;
    }

    foreach ($aAcoesAdicionar as $iAcao) {

      $oAcaoAdicionar = Administrativo_Model_Acao::getById($iAcao);

      $oUsuarioContribuinte = new Administrativo_Model_UsuarioContribuinteAcao();
      $oUsuarioContribuinte->setUsuarioContribuinte($this->entity);
      $oUsuarioContribuinte->setAcao($oAcaoAdicionar->getEntity());
      $this->em->persist($oUsuarioContribuinte->getEntity());
    }

    $this->em->flush();
  }

  /**
   * Copia as permissoes definidas no perfil para o usu�rio neste contribuinte
   * @param Administrativo_Model_Perfil $perfil
   */
  public function copiaPerfilAcoes(Administrativo_Model_Perfil $perfil) {
    $this->adicionaAcoes($perfil->getAcoes());
  }

  /**
   * Valida os Dados
   * @param array $attrs
   * @return multitype:boolean multitype:
   */
  private function isValid(array $attrs) {

    return array('valid' => true, 'errors' => array());
  }

  /**
   * Retorna a Instância do contribuinte
   * @return Contribuinte_Model_ContribuinteAbstract
   */
  public static function getContribuinte($iCodigoContribuinte) {

    $oContribuinte   = Administrativo_Model_UsuarioContribuinte::getById($iCodigoContribuinte);
    $iCodigoUsuario  = $oContribuinte->getId();
    $oUsuarioRetorno = NULL;

    switch ($oContribuinte->getTipoContribuinte()) {

      case Administrativo_Model_UsuarioContribuinte::CONTRIBUINTE_EVENTUAL:

        $oUsuarioRetorno = Contribuinte_Model_ContribuinteEventual::getById($iCodigoUsuario);
        break;

      case Administrativo_Model_UsuarioContribuinte::CONTRIBUINTE_MUNICIPAL :
        $oUsuarioRetorno = Contribuinte_Model_Contribuinte::getById($iCodigoUsuario);
        break;
      }

      return $oUsuarioRetorno;
  }

  /**
   * Retorna uma lista de todos os contribuintes cadastrados e habilitados no sistema
   *
   * @param null   $sColunaOrdem
   * @param string $sOrdemDirecao
   * @return Administrativo_Model_UsuarioContribuinte[]
   */
  public static function getContribuintes($sColunaOrdem = NULL, $sOrdemDirecao = 'ASC') {

    $oQueryBuilder = self::getEm()->createQueryBuilder();
    $oQueryBuilder->select('uc');
    $oQueryBuilder->from('Administrativo\UsuarioContribuinte', 'uc');
    $oQueryBuilder->where('uc.im IS NOT NULL');
    $oQueryBuilder->andWhere('uc.habilitado = TRUE');

    if ($sColunaOrdem) {
      $oQueryBuilder->orderBy("uc.{$sColunaOrdem}", $sOrdemDirecao);
    }

    $aRetorno = array();

    foreach ($oQueryBuilder->getQuery()->getResult() as $oUsuarioContribuinte) {
      $aRetorno[] = new static::$className($oUsuarioContribuinte);
    }

    return $aRetorno;
  }

  /**
   * Retorna uma lista dos prestadores de serviços cadastrados e habilitados no sistema
   *
   * @param null   $sColunaOrdem
   * @param string $sOrdemDirecao
   * @return Administrativo_Model_UsuarioContribuinte[]
   */
  public static function getPrestadores($sColunaOrdem = NULL, $sOrdemDirecao = 'ASC') {

    $oQueryBuilder = self::getEm()->createQueryBuilder();
    $oQueryBuilder->select('uc');
    $oQueryBuilder->distinct(TRUE);
    $oQueryBuilder->from('Administrativo\UsuarioContribuinte', 'uc');
    $oQueryBuilder->where('uc.im IS NOT NULL');
    $oQueryBuilder->andWhere('uc.habilitado = TRUE');
    $oQueryBuilder->andWhere("uc.tipo_emissao in (
      '".Contribuinte_Model_Contribuinte::TIPO_EMISSAO_NOTA."',
      '".Contribuinte_Model_Contribuinte::TIPO_EMISSAO_DMS."'
    )");

    if ($sColunaOrdem) {
      $oQueryBuilder->orderBy("uc.{$sColunaOrdem}", $sOrdemDirecao);
    }

    $aRetorno = array();

    foreach ($oQueryBuilder->getQuery()->getResult() as $oUsuarioContribuinte) {
      $aRetorno[] = new static::$className($oUsuarioContribuinte);
    }

    return $aRetorno;
  }


  public static function atualizaTipoEmissao ($aContribuintesAtualizar) {

    if (!is_array($aContribuintesAtualizar) && count($aContribuintesAtualizar) <= 0) {
      throw new Exception ('Problemas ao atualizar tipo de emissão dos contribuintes!');
    }

    foreach ($aContribuintesAtualizar as $aUsuarioContribuinteAtualizar) {

      $aUsuarioContribuinte          = NULL;
      $iTipoEmissaoWeb               = NULL;
      $iWebServiceUsuarioTipoEmissao = NULL;

      if ($aUsuarioContribuinteAtualizar == NULL) {
        throw new Exception ('Problemas ao atualizar tipo de emissão dos contribuintes!');
      }

      if (in_array('attr', get_class_methods($aUsuarioContribuinteAtualizar))) {

        $iTipoEmissaoWeb               = $aUsuarioContribuinteAtualizar->attr('tipo_emissao');
        $iWebServiceUsuarioTipoEmissao = (!empty($iTipoEmissaoWeb) ? $iTipoEmissaoWeb : 9);

        $aUsuarioContribuintes =
          Administrativo_Model_UsuarioContribuinte::getByAttribute('cnpj_cpf',
                                                                   $aUsuarioContribuinteAtualizar->attr('cnpj'));

        $iCgm = $aUsuarioContribuinteAtualizar->attr('cgm');
      } else {

        // quando o usuario é tomador que não tem inscrição os dados vem de outro metodo webservice
        if (empty($aUsuarioContribuinteAtualizar->cgccpf) || empty($aUsuarioContribuinteAtualizar->tipo_emissao)) {

          $aUsuarioContribuinteAtualizar->cgccpf       = $aUsuarioContribuinteAtualizar->iCnpj;
          $aUsuarioContribuinteAtualizar->tipo_emissao = 9; //tipo emissao tomador
          $aUsuarioContribuinteAtualizar->numero_cgm   = $aUsuarioContribuinteAtualizar->iCodigoCgm;
        }

        $iTipoEmissaoWeb               = $aUsuarioContribuinteAtualizar->tipo_emissao;
        $iWebServiceUsuarioTipoEmissao = (!empty($iTipoEmissaoWeb) ? $iTipoEmissaoWeb : 9);

        $aUsuarioContribuintes =
          Administrativo_Model_UsuarioContribuinte::getByAttribute('cnpj_cpf',
                                                                   $aUsuarioContribuinteAtualizar->cgccpf);

        $iCgm = $aUsuarioContribuinteAtualizar->numero_cgm;
      }

      if (!is_array($aUsuarioContribuintes)) {
        $aUsuarioContribuintes = array($aUsuarioContribuintes);
      }

      foreach ($aUsuarioContribuintes as $oContribuinte) {

        if (!$oContribuinte instanceof Administrativo_Model_UsuarioContribuinte) {
          continue;
        }

        if ($iTipoEmissaoWeb == $oContribuinte->getTipoEmissao()) {
          continue;
        }

        $aTiposEmissao = array(Contribuinte_Model_ContribuinteAbstract::TIPO_EMISSAO_DMS,
                               Contribuinte_Model_ContribuinteAbstract::TIPO_EMISSAO_NOTA);

        $iTipoContribuinte = Administrativo_Model_UsuarioContribuinte::CONTRIBUINTE_MUNICIPAL;
        $iCgmAtualizar = NULL;

        if (!in_array($iWebServiceUsuarioTipoEmissao, $aTiposEmissao)) {
          $iTipoContribuinte = Administrativo_Model_UsuarioContribuinte::CONTRIBUINTE_EVENTUAL;
          $iCgmAtualizar     = $iCgm;
        }

        $aDados = array(
          'usuario'           => $oContribuinte->getUsuario(),
          'contribuinte'      => $oContribuinte->getIm(),
          'cnpj_cpf'          => $oContribuinte->getCnpjCpf(),
          'tipo_emissao'      => $iWebServiceUsuarioTipoEmissao,
          'tipo_contribuinte' => $iTipoContribuinte,
          'cgm'               => $iCgmAtualizar
        );

        $oContribuinte->persist($aDados);

        $oContribuinte->limparAcoes(TRUE);
        $oTipoEmissaoPerfil = $oContribuinte->getPerfilTipoEmissao($iWebServiceUsuarioTipoEmissao);

        $oPerfil = Administrativo_Model_Perfil::getById($oTipoEmissaoPerfil->iCodigoPerfil);

        $oContribuinte->adicionaAcoes($oPerfil->getAcoes());
      }
    }
  }

  /**
   * Retorna o Perfil e Tipo de Emissão do usuario
   * @param $iTipoEmissao
   *
   * @return Object
   */
  public static function getPerfilTipoEmissao ($iTipoEmissao) {

    $oEmissaoTipo = new stdClass();

    if ($iTipoEmissao == Contribuinte_Model_Contribuinte::TIPO_EMISSAO_DMS) {

      $oEmissaoTipo->iCodigoPerfil      = 7;
      $oEmissaoTipo->iCodigoTipoEmissao = 11;

    } else if ($iTipoEmissao == Contribuinte_Model_Contribuinte::TIPO_EMISSAO_NOTA) {

      $oEmissaoTipo->iCodigoPerfil      = 1;
      $oEmissaoTipo->iCodigoTipoEmissao = 10;
    } else {

      // tomador
      $oEmissaoTipo->iCodigoPerfil      = 4;
      $oEmissaoTipo->iCodigoTipoEmissao = 9;
    }

    return $oEmissaoTipo;
  }

  /**
   * Método que busca os contribuintes por Acao
   * @param  integer $iIdAcao
   * @return array
   * @throws Exception
   */
  public static function getContribuinteByAcao($iIdAcao) {

    try {

      $em         = self::getEm();
      $sDql       = 'SELECT uc.im,
                            u.nome
                     FROM Administrativo\UsuarioContribuinte uc
                     INNER JOIN Administrativo\UsuarioContribuinteAcao uca WITH uc.id = uca.usuario_contribuinte
                     INNER JOIN Administrativo\Usuario u WITH u.id = uc.usuario
                     WHERE uca.acao = :i';
      $oQuery     = $em->createQuery($sDql)->setParameters(array('i' => $iIdAcao));
      $aResultado = $oQuery->getResult();

      return $aResultado;
    } catch (Exception $oError) {
      throw $oError;
    }
  }

  /**
   * Consulta apenas o usuario contribuinte pelo tipo do usuario e cnpj ou cpf informados
   *
   * @param integer $iCnpjCpf
   * @param integer $iTipo
   * @return mixed
   * @throws Exception
   */
  public static function getContribuinteByCnpjTipo($iCnpjCpf, $iTipo) {

    try {

      $oEm        = self::getEm();
      $sDql       = 'SELECT uc                                                         ';
      $sDql      .= '  FROM Administrativo\UsuarioContribuinte uc                      ';
      $sDql      .= '       INNER JOIN Administrativo\Usuario u WITH u.id = uc.usuario ';
      $sDql      .= ' WHERE uc.cnpj_cpf = :uccnpj_cpf                                  ';
      $sDql      .= '   AND u.tipo = :utipo                                            ';
      $oQuery     = $oEm->createQuery($sDql)->setParameters(array('uccnpj_cpf' => $iCnpjCpf, 'utipo' => $iTipo));
      $aResultado = $oQuery->getResult();

      if (empty($aResultado)) {
        return NULL;
      }
      return $aResultado[0];
    } catch (Exception $oError) {
      throw $oError;
    }
  }

  /**
   * Obtem o Usuario principal do contribuinte
   *
   * @param string $sCnpj CNPJ/CPF do contribuinten
   * @return mixed
   * @throws Exception
   */
  public function getUsuarioPrincipal($sCnpj = NULL) {

    try {

      if (!empty($sCnpj)) {
        $sParamCpnj = $sCnpj;
      } else {
        $sParamCpnj = $this->entity->getCnpjCpf();
      }

      $aAtributos = array(
                          "cnpj" => $sParamCpnj,
                          "login" => $sParamCpnj,
                          "principal" => "true"
                          );

     $oUsuario = Administrativo_Model_Usuario::getByAttributes($aAtributos);

     if (!$oUsuario) {
      return NULL;
     }

      return $oUsuario[0];
    } catch (Exception $oError) {
      throw $oError;
    }
  }

  /**
   * Método para atualizar o nome no cadastro de Usuários #3815
   * @param array $aContribuintes
   * @throw Exception
   */
  public static function atualizaNomeUsuarioContribuinte($aContribuintes) {

    try {

      if (is_array($aContribuintes) || !empty($aContribuintes)) {

        foreach ($aContribuintes as $aContribuinte) {

          $sCnpj = (empty($aContribuinte->cgccpf) ? $aContribuinte->attr('cnpj') : $aContribuinte->cgccpf);
          $sNome = (empty($aContribuinte->nome) ? trim($aContribuinte->attr('nome')) : $aContribuinte->nome);

          $oUsuario = self::getUsuarioPrincipal($sCnpj);

          if (!$oUsuario || is_null($oUsuario)) {
            continue;
          }

          if ($oUsuario->getNome() != $sNome) {

            $oUsuario->setNome($sNome);
            $oUsuario->persist();

          }
        }
      }
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function getNotasIrregulares($id){

    $aNotas            = Contribuinte_Model_Nota::getByAttributes(array('id_contribuinte' => $id));
    $aNotasIrregulares = new ArrayCollection();

    foreach($aNotas as $i => $oNota){

      foreach($oNota->getIrregularidades() as $j => $oIrregularidade){

        $sIrregularidadeId = $oIrregularidade->getId();
        if(!empty($sIrregularidadeId)){
          $aNotasIrregulares[] = $aNotas[$i];
          break;
        }
      }
    }

    return $aNotasIrregulares;
  }

  /**
   * Retorna ArrayCollection de Administrativo\UsuarioContribuinte conforme filtros aplicados
   * @param  string          $sContribuinteInscricaoMunicipal
   * @param  string          $sNotaDataEmissaoInicio
   * @param  string          $sNotaDataEmissaoFim
   * @return ArrayCollection
   */
  public function getContribuintesNotasIrregulares($sContribuinteInscricaoMunicipal = null, $sNotaDataEmissaoInicio = null, $sNotaDataEmissaoFim = null){

    try {

      $oEntityManager = self::getEm();
      $aParans        = array();

      $sDql  = ' select uc                                                                     ';
      $sDql .= '   from Administrativo\UsuarioContribuinte uc                                  ';
      $sDql .= '  inner join Administrativo\Usuario u           WITH u.id = uc.id_usuario      ';
      $sDql .= '  inner join Contribuinte\Nota n                WITH n.id_contribuinte = uc.id ';
      $sDql .= '  inner join Contribuinte\NotaIrregularidade ni WITH ni.id_notas       = n.id  ';
      $sDql .= '  where 1 = 1                                                                  ';

      if(!empty($sContribuinteInscricaoMunicipal)){

        $sDql          .= ' and uc.im = :im ';
        $aParans['im']  = $sContribuinteInscricaoMunicipal;
      }

      if(!empty($sNotaDataEmissaoInicio)){

        $sDql                  .= ' and n.dt_nota >= :dataInicio ';
        $aParans['dataInicio']  = $sNotaDataEmissaoInicio;
      }

      if(!empty($sNotaDataEmissaoFim)){

        $sDql               .= ' and n.dt_nota <= :dataFim ';
        $aParans['dataFim']  = $sNotaDataEmissaoFim;
      }

      $sDql .= ' order by u.nome asc ';

      $oQuery = $oEntityManager->createQuery($sDql)->setParameters($aParans);
      return $oQuery->getResult();
    } catch (Excpetion $oErro){
      throw $oErro;
    }
  }
}