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


/**
 * Classe responsável pela Manipulação do cadastro de usuários
 *
 * @package Administrativo\Models\Usuario
 */

/**
 * Class Administrativo_Model_Usuario
 * @package Administrativo/Model
 */
class Administrativo_Model_Usuario extends Administrativo_Lib_Model_Doctrine {

  static protected $entityName = 'Administrativo\Usuario';
  static protected $className = __CLASS__;

  /**
   * Constante que determina id do tipo Fiscal
   * @var integer
   */
  const USUARIO_TIPO_FISCAL = 3;

  /**
   * Retorna vetor de contribuintes.
   *
   * @tutorial Com os seguintes campos:
   *   tipo,
   *   cgccpf,
   *   nome,
   *   nome_fanta,
   *   identidade,
   *   inscr_est,
   *   tipo_lograd,
   *   lograd,
   *   issruas.q02_numero,
   *   complemento,
   *   bairro,
   *   cod_ibge,
   *   munic,
   *   uf,
   *   cod_pais,
   *   pais,
   *   cep,
   *   telefone,
   *   fax,
   *   celular,
   *   email,
   *   inscricao,
   *   data_inscricao,
   *   tipo_classificacao,
   *   optante_simples,
   *   sub_tributario,
   *   exigibilidade,
   *   regime,
   *   incentivo_fiscal

   * @return Administrativo_Model_Contribuinte[]
   */
  public function getContribuintes() {

    $aUsuariosContribuintes = $this->getUsuariosContribuintes();
    $aContribuintes         = array();

    foreach ($aUsuariosContribuintes as $oUsuarioContribuinte) {

      $oUsuarioRetorno = Administrativo_Model_UsuarioContribuinte::getContribuinte($oUsuarioContribuinte->getId());

      $aContribuintes[$oUsuarioContribuinte->getId()] = $oUsuarioRetorno;
    }

    return $aContribuintes;
  }

  /**
   * Todos os registros de UsuariosContribuintes do usuário
   *
   * @return Administrativo_Model_UsuarioContribuinte[]
   */
  public function getUsuariosContribuintes() {

    $a = array();

    foreach ($this->entity->getUsuariosContribuintes() as $v) {

      if (!$v->getHabilitado()) {
        continue;
      }
      $a[] = new Administrativo_Model_UsuarioContribuinte($v);
    }

    return $a;
  }

  /**
   * Retorna todas as ações do usuário para um contribuinte
   *
   * @param integer $contribuinte IM do contribuinte
   * @param string $modulo Filtro por módulo
   * @return Array
   */
  public function getAcoes($contribuinte = null, $modulo = null) {

    $a = array();

    foreach ($this->entity->getAcoes() as $acao) {

      $acao = new Administrativo_Model_Acao($acao);

      if ($modulo === null || strtolower($acao->getControle()->getModulo()->getNome()) === $modulo) {

        $a[] = $acao;
      }
    }

    // Se for diferente de "contador" pega as permissoes dos usuarios clientes
    if ($this->entity->getTipo() != 2) {

      $usuario_contribuinte = Administrativo_Model_UsuarioContribuinte::getByUsuarioContribuinte($this, $contribuinte);

      foreach ($usuario_contribuinte as $uc) {
        $a = array_merge($a, $uc->getAcoes($modulo));
      }
    }

    return $a;
  }

  /**
   * Retorna as ações administrativas (sem contribuinte) do usuário
   *
   * @return Administrativo_Model_Acao[]
   */
  public function getAcoesAdm() {

    $acoes = array();

    foreach ($this->entity->getAcoes() as $acao) {
      $acoes[] = new Administrativo_Model_Acao($acao);
    }

    return $acoes;
  }

  /**
   * Retorna os módulos que o usuário tem permissão para acessar
   *
   * @return Administrativo_Model_Modulo[]
   */
  public function getModulos() {

    $modulos = array();

    foreach ($this->getAcoes() as $a) {

      $m = $a->getControle()->getModulo();

      if (array_search($m, $modulos) == false) {
        $modulos[] = $m;
      }
    }

    return $modulos;
  }

  /**
   * Perfil do usuário
   *
   * @return Administrativo_Model_Perfil
   */
  public function getPerfil() {
    return new Administrativo_Model_Perfil($this->entity->getPerfil());
  }

  /**
   * Usuário administrativo "Sim" ou "Não"
   *
   * @return string
   */
  public function getAdministrativoString() {
    return $this->getAdministrativo() ? 'Sim' : 'Não';
  }

  public function adicionaAcoes(array $acoes) {

    foreach ($acoes as $a) {
      $this->addAcao($a->getEntity());
    }

    $this->em->flush();
  }

  /**
   * Adiciona um UsuarioContribuinte ao usuário
   *
   * @param Administrativo_Model_UsuarioContribuinte $oUsuarioContribuinte
   */
  public function addUsuarioContribuinte(Administrativo_Model_UsuarioContribuinte $oUsuarioContribuinte) {
    $this->entity->addUsuariosContribuintes($oUsuarioContribuinte->getEntity());
  }

  /**
   * Remove todas as ações permitidas para o Usuario
   */
  public function limparAcoes() {

    foreach ($this->entity->getAcoes() as $a) {
      $this->delAcao($a);
    }

    $this->em->flush();
  }

  /**
   * Metodo responsável por alterar a senha do usuário
   *
   * @param $antiga
   * @param $nova
   * @return bool
   */
  public function trocaSenha($antiga, $nova) {

    $antiga = hash('sha1', $antiga);

    if ($this->getSenha() == $antiga) {

      $this->setSenha($nova);
      $this->em->persist($this->entity);
      $this->em->flush();
      return true;
    } else {
      return false;
    }
  }

  /**
   * Salva o usuario
   *
   * @return boolean
   */
  public function persistUsuario() {

    $this->definePermissoes();

    self::getEm()->persist($this->getEntity());
    self::getEm()->flush();

    return TRUE;
  }

  /**
   * Trata os dados do formulário para serem salvos no banco de dados
   *
   * @param array $aDados
   * @return $this|bool
   */
  public function persist(array $aDados = NULL) {

    if (!is_array($aDados)) {
      return self::persistUsuario();
    }

    if (empty($aDados['senha'])) {
      unset($aDados['senha']);
    }

    $aValidaDados = $this->isValid($aDados);

    if ($aValidaDados['valid']) {

      // seta atributos para serem salvos no banco, habilitado sempre inicia como true
      if (isset($aDados['nome'])) {
        $this->entity->setNome($aDados['nome']);
      }

      if (isset($aDados['fone'])) {
        $this->entity->setTelefone(DBSeller_Helper_Number_Format::getNumbers($aDados['fone']));
      }

      if (isset($aDados['login'])) {
        $this->entity->setLogin($aDados['login']);
      }

      if (isset($aDados['senha'])) {
        $this->entity->setSenha($aDados['senha']);
      }

      if (isset($aDados['email'])) {
        $this->entity->setEmail($aDados['email']);
      }

      if (isset($aDados['habilitado'])) {
        $this->entity->setHabilitado(true);
      }

      if (isset($aDados['administrativo'])) {
        $this->entity->setAdministrativo($aDados['administrativo']);
      }

      if (isset($aDados['tipo'])) {
        /* Se ha troca de tipo de usuario entre contador > contribuinte */
        if ($this->getId() !== NULL && $this->getTipo() == 2 && $aDados['tipo'] == 1) {
          $aAtributos = array(
                              'set' => array('habilitado' => "'f'"),
                              'where' => array('id_usuario' => $this->getId(),
                              "cnpj_cpf" => "<> '{$this->getCnpj()}'")
          );
          Administrativo_Model_UsuarioContribuinte::update($aAtributos['set'], $aAtributos['where']);
        } else if ($this->getId() !== NULL && $this->getTipo() == 1 && $aDados['tipo'] == 2) {
          /* Se a troca de tipo de usuario entre contribuinte > contador*/
          $aAtributos = array(
                              'set' => array('habilitado' => "'t'"),
                              'where' => array('id_usuario' => $this->getId(),
                              "cnpj_cpf" => "<> '{$this->getCnpj()}'")
          );
          Administrativo_Model_UsuarioContribuinte::update($aAtributos['set'], $aAtributos['where']);
        }
        $this->entity->setTipo($aDados['tipo']);
      }

      if (isset($aDados['cgm'])) {
        $this->entity->setCgm(DBSeller_Helper_Number_Format::getNumbers($aDados['cgm']));
      }

      if (isset($aDados['cnpj'])) {
        $this->entity->setCnpj(DBSeller_Helper_Number_Format::getNumbers($aDados['cnpj']));
      }

      if (isset($aDados['perfil'])) {

        if (is_numeric($aDados['perfil'])) {
          $aDados['perfil'] = Administrativo_Model_Perfil::getById($aDados['perfil'])->getEntity();
        }

        $this->entity->setPerfil($aDados['perfil']);
      }

      if (isset($aDados['principal'])) {
        $this->entity->setPrincipal($aDados['principal']);
      }

      $this->entity->setTentativa(0);

      /* Somente usuarios novos */
      if ($this->getId() === NULL) {

        // Verifica se o tipo de usuário é Contador e e se for vincula as empresas enviadas pelo e-cidade
        if ($this->getTipo() == Administrativo_Model_TipoUsuario::$CONTADOR) {

          $aEmpresas = Administrativo_Model_Empresa::getByCnpj($this->getCnpj());

          // Vincula ações de contribuintes
          $this->vinculaEmpresas($aEmpresas);
        }

        // Verifica se o usuário é do tipo Contribuinte para vincular a empresa
        if ($this->getTipo() == Administrativo_Model_TipoUsuario::$CONTRIBUINTE) {

          $oEmpresa = Contribuinte_Model_Contribuinte::getByCpfCnpj($this->getCnpj());

          $oUsuarioContribuinte = new Administrativo_Model_UsuarioContribuinte();
          $oUsuarioContribuinte->setIm  ($oEmpresa->getInscricaoMunicipal());
          $oUsuarioContribuinte->setCnpjCpf($oEmpresa->getCgcCpf());
          $oUsuarioContribuinte->setUsuario($this->entity);
          $oUsuarioContribuinte->setHabilitado(true);

          // Verifica a inscrição municipal informada
          if (!empty($aDados['insc_municipal'])) {
            $oUsuarioContribuinte->setIm($aDados['insc_municipal']);
          }

          $this->addUsuarioContribuinte($oUsuarioContribuinte);

          // Salva os dados complementares do usuário contribuinte
          if ($oEmpresa instanceof Contribuinte_Model_Contribuinte) {
            self::salvarDadosComplementaresUsuarioContribuinte($oEmpresa->getInscricaoMunicipal());
          }
        }

        // Vincula ações administrativas
        $aAcoes                = $this->getPerfil()->getAcoes();
        $aAcoesAdministrativas = array();

        foreach ($aAcoes as $oAcao) {

          $aAcoesAdministrativas[] = $oAcao;
        }

        $this->adicionaAcoes($aAcoesAdministrativas);
      }

      $this->em->persist($this->entity);
      $this->em->flush();

      return $this;
    } else {
      return $aValidaDados['errors'];
    }
  }

  /**
   * Recebe um vetor com as empresas vindas do WebService e vincula com o usuário
   *
   * @param $empresas
   */
  public function vinculaEmpresas($empresas) {

    foreach ($empresas as $oEmpresa) {

      $oUsuarioContribuinte = new Administrativo_Model_UsuarioContribuinte();
      $oUsuarioContribuinte->setUsuario($this->entity);
      $oUsuarioContribuinte->setIm($oEmpresa->attr('inscricao'));
      $oUsuarioContribuinte->setCnpjCpf($oEmpresa->attr('cnpj'));
      $oUsuarioContribuinte->setHabilitado(true);
      $this->addUsuarioContribuinte($oUsuarioContribuinte);

      // Salva os dados complementares do usuário contribuinte
      self::salvarDadosComplementaresUsuarioContribuinte($oEmpresa->attr('inscricao'));
    }
  }

  /**
   * metodo responsável por gerar as permissoes do usuario
   *
   * @return Administrativo_Model_UsuarioContribuinte
   */
  protected function definePermissoes () {

    if ($this->getId() == null) {

      // verifica se o tipo de usuário é Contador e e se for vincula as empresas enviadas pelo e-cidade
      if ($this->getTipo() == Administrativo_Model_TipoUsuario::$CONTADOR) {

        $empresas = Administrativo_Model_Empresa::getByCnpj($this->getCnpj());

        // vincula ações de contribuintes
        $this->vinculaEmpresas($empresas);
      }

      // verifica se o usuário é do tipo Contribuinte para vincular a empresa
      if ($this->getTipo() == Administrativo_Model_TipoUsuario::$CONTRIBUINTE) {

        $oEmpresa = Contribuinte_Model_Contribuinte::getByCpfCnpj($this->getCnpj());

        if (!empty($oEmpresa)) {

          $uc = new Administrativo_Model_UsuarioContribuinte();
          $uc->setIm($oEmpresa->getInscricaoMunicipal());
          $uc->setUsuario($this->entity);
          $uc->setHabilitado(true);
          $uc->setCnpjCpf($this->getCnpj());
          $this->addUsuarioContribuinte($uc);

        }
      }

      // vincula ações administrativas
      $acoes = $this->getPerfil()->getAcoes();
      $acoes_adm = array();

      foreach ($acoes as $a) {

        if (strtolower($a->getControle()->getModulo()->getNome()) == 'administrativo' || $a->getId() == 37) {
          $acoes_adm[] = $a;
        }
      }

      $this->adicionaAcoes($acoes_adm);
    }

    return $this;
  }

  /**
   * Copia ações definidas no perfil para o usuário
   *
   * @param Administrativo_Model_Perfil $perfil
   */
  public function copiaAcoesPerfil(Administrativo_Model_Perfil $perfil) {

    $this->setAdministrativo($perfil->getAdministrativo());

    foreach ($perfil->getAcoes() as $a) {
      $this->addAcao($a->getEntity());
    }

    $this->em->persist($this->entity);
    $this->em->flush();
  }

  /**
   * @return mixed
   */
  public function getTipoString() {
    return Administrativo_Model_TipoUsuario::getById($this->getTipo());
  }

  /**
   * Metodo Responsável por atualizar a lista de contribuintes
   *
   * @param array $contribuintes_novos
   */
  public function atualizaListaContribuintes($contribuintes_novos) {

    $contribuintes_velhos = Administrativo_Model_UsuarioContribuinte::getByAttribute('usuario', $this->getId());
    $novos_im  = array();
    $velhos_im = array();

    // monta array de inscricoes novas. recebidas pelo webservice
    foreach ($contribuintes_novos as $c) {
      $novos_im[$c->attr('inscricao')] = $c;
    }

    if (!empty($contribuintes_velhos)) {

      // monta array de inscricoes velhas. recebidas do banco de dados
      if (is_array($contribuintes_velhos)) {

        foreach ($contribuintes_velhos as $c) {

          $velhos_im[$c->getIm()] = $c;
        }

      } else {

        $velhos_im[$contribuintes_velhos->getIm()] = $contribuintes_velhos;
      }
    }

    // diferença entre as novas e velhas são as inscricoes que precisam ser adicionadas
    $adicionar = array_diff_key($novos_im, $velhos_im);

    // diferença entre as velhas e as novas sao as incricões que precisam ser removidas
    $remover = array_diff_key($velhos_im, $novos_im);

    // Reabilita vinculos existentes
    foreach ($novos_im as $oNovoContribuinte) {

      if (isset($velhos_im[$oNovoContribuinte->attr('inscricao')])) {

        $oUsuarioContribuinteExistente = $velhos_im[$oNovoContribuinte->attr('inscricao')];
        $oUsuarioContribuinteExistente->setHabilitado(TRUE);
        $oUsuarioContribuinteExistente->persist();
      }
    }

    // Cria novos vinculos
    foreach ($adicionar as $oNovoContribuinte) {

      $oUsuarioContribuinte = new Administrativo_Model_UsuarioContribuinte();
      $oUsuarioContribuinte->setUsuario($this->entity);
      $oUsuarioContribuinte->setIm($oNovoContribuinte->attr('inscricao'));
      $oUsuarioContribuinte->setCnpjCpf($oNovoContribuinte->attr('cnpj'));
      $oUsuarioContribuinte->setHabilitado(true);
      $this->addUsuarioContribuinte($oUsuarioContribuinte);
      $oUsuarioContribuinte->persist();
    }

    // Desabilita o usuario contribuinte
    foreach ($remover as $oUsuarioRemover) {

      $oUsuarioRemover->setHabilitado(FALSE);
      $oUsuarioRemover->persist();
    }
  }

  /**
   * Valida campos do modelo. Retorna um vetor com dois campos
   * @param array $attrs
   *
   * @return array
   */
  private function isValid(array $attrs) {
    return array('valid' => true, 'errors' => array());
  }

  /**
   * Habilita/Desabilita o usuario
   * @param  boolean $bStatus
   * @return boolean
   */
  public function trocaStatus($bStatus = FALSE) {

    if (is_bool($bStatus)) {

      $this->setHabilitado($bStatus);
      $this->em->persist($this->entity);
      $this->em->flush();

      return true;
    } else {
      return false;
    }
  }

  /**
   * Função responsável por gerar o Hash
   * @return string
   */
  public function criarHash() {

    $sStringHash = "ECidadeOnline2{$this->getCnpj()}{$this->getEmail()}{$this->getId()}";
    $sStringHash = hash('sha1', $sStringHash);
    return $sStringHash;
  }

  /**
   * Envia um email com os dados para Recuperacao/alteração da senha do usuário
   * @param Administrativo_Model_Usuario $oUsuario instancia do usuario
   */
  public static function enviarEmailSenha(Administrativo_Model_Usuario $oUsuario) {

    $sHash = $oUsuario->criarHash();
    $oView = new Zend_View();
    $oView->setScriptPath(APPLICATION_PATH . '/modules/auth/views/scripts/login/');
    $oView->sUrlRecuperarSenha = $oView->serverUrl("/auth/login/recuperar-senha/hash/{$sHash}");
    $oView->nome               = $oUsuario->getEntity()->getNome();
    $sTextoEmail               = $oView->render('email-recuperacao-senha.phtml');

    $oTranslate = Zend_Registry::get('Zend_Translate');

    $lEmail = DBSeller_Helper_Mail_Mail::send(
      $oUsuario->getEmail(),
      $oTranslate->_('ECidadeOnline2 - Recuperação de Senha'),
      $sTextoEmail
    );

    if (!$lEmail) {
      throw new Exception('Email não enviado. Favor contate o suporte da prefeitura.');
    }
  }

  /**
   * Salva os dados complementares do usuário contribuinte
   *
   * @param int $iInscricaoMunicipal
   * @return bool
   */
  private function salvarDadosComplementaresUsuarioContribuinte($iInscricaoMunicipal) {

    try {

      $oContribuinte = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

      $oContribuinteComplemento = Administrativo_Model_UsuarioContribuinteComplemento::getById($oContribuinte->getCgcCpf());
      $oContribuinteComplemento->setInscricaoMunicipal($oContribuinte->getInscricaoMunicipal());
      $oContribuinteComplemento->setInscricaoEstadual($oContribuinte->getInscricaoEstadual());
      $oContribuinteComplemento->setCnpjcpf($oContribuinte->getCgcCpf());
      $oContribuinteComplemento->setRazaoSocial($oContribuinte->getRazaoSocial() ? : $oContribuinte->getNome());
      $oContribuinteComplemento->setNomeFantasia($oContribuinte->getNomeFantasia());
      $oContribuinteComplemento->setEnderecoPaisCodigo();
      $oContribuinteComplemento->setEnderecoUf($oContribuinte->getEstado());
      $oContribuinteComplemento->setEnderecoMunicipioCodigo($oContribuinte->getCodigoIbgeMunicipio());
      $oContribuinteComplemento->setEnderecoDescricao($oContribuinte->getDescricaoLogradouro());
      $oContribuinteComplemento->setEnderecoBairro($oContribuinte->getLogradouroBairro());
      $oContribuinteComplemento->setEnderecoNumero($oContribuinte->getLogradouroNumero());
      $oContribuinteComplemento->setEnderecoComplemento($oContribuinte->getLogradouroComplemento());
      $oContribuinteComplemento->setEnderecoCep($oContribuinte->getCep());
      $oContribuinteComplemento->setContatoEmail($oContribuinte->getEmail());
      $oContribuinteComplemento->setContatoTelefone($oContribuinte->getTelefone());
      $oContribuinteComplemento->persist();

      return TRUE;
    } catch(Exception $oErro) {
      return FALSE;
    }
  }

  /**
   * Verifica se o usuário está com o login bloqueado
   * @return boolean
   */
  public function isLoginBloqueado() {

    if ($this->entity->getTentativa() >= 3) {

      $oParametrosPrefeitura = Administrativo_Model_ParametroPrefeitura::getAll();
      $oDataTentativa = $this->entity->getDataTentativa();
      $oComparaData = new Zend_Date($oDataTentativa->getTimestamp());
      $oComparaData->add($oParametrosPrefeitura[0]->getTempoBloqueio(), Zend_Date::MINUTE);
      $oNow = new Zend_date();

      if ($oComparaData->compare($oNow) != -1) {
        return TRUE;
      }
    }

    return FALSE;
  }
}
