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

//MODULO: agua
//CLASSE DA ENTIDADE aguacategoriaconsumo
class cl_aguacategoriaconsumo { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $numrows_incluir = 0; 
   var $numrows_alterar = 0; 
   var $numrows_excluir = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $erro_campo = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $x13_sequencial = 0; 
   var $x13_exercicio = 0; 
   var $x13_descricao = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 x13_sequencial = int4 = C?digo 
                 x13_exercicio = int4 = Exerc?cio 
                 x13_descricao = varchar(100) = Descri??o 
                 ";
   //funcao construtor da classe 
   function cl_aguacategoriaconsumo() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("aguacategoriaconsumo"); 
     $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
   }
   //funcao erro 
   function erro($mostra,$retorna) { 
     if(($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )){
        echo "<script>alert(\"".$this->erro_msg."\");</script>";
        if($retorna==true){
           echo "<script>location.href='".$this->pagina_retorno."'</script>";
        }
     }
   }
   // funcao para atualizar campos
   function atualizacampos($exclusao=false) {
     if($exclusao==false){
       $this->x13_sequencial = ($this->x13_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["x13_sequencial"]:$this->x13_sequencial);
       $this->x13_exercicio = ($this->x13_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["x13_exercicio"]:$this->x13_exercicio);
       $this->x13_descricao = ($this->x13_descricao == ""?@$GLOBALS["HTTP_POST_VARS"]["x13_descricao"]:$this->x13_descricao);
     }else{
       $this->x13_sequencial = ($this->x13_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["x13_sequencial"]:$this->x13_sequencial);
     }
   }
   // funcao para Inclus?o
   function incluir ($x13_sequencial){ 
      $this->atualizacampos();
     if($this->x13_exercicio == null ){ 
       $this->erro_sql = " Campo Exerc?cio n?o informado.";
       $this->erro_campo = "x13_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->x13_descricao == null ){ 
       $this->erro_sql = " Campo Descri??o n?o informado.";
       $this->erro_campo = "x13_descricao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($x13_sequencial == "" || $x13_sequencial == null ){
       $result = db_query("select nextval('aguacategoriaconsumo_x13_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: aguacategoriaconsumo_x13_sequencial_seq do campo: x13_sequencial"; 
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->x13_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from aguacategoriaconsumo_x13_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $x13_sequencial)){
         $this->erro_sql = " Campo x13_sequencial maior que ?ltimo n?mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n?mero.";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->x13_sequencial = $x13_sequencial; 
       }
     }
     if(($this->x13_sequencial == null) || ($this->x13_sequencial == "") ){ 
       $this->erro_sql = " Campo x13_sequencial n?o declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into aguacategoriaconsumo(
                                       x13_sequencial 
                                      ,x13_exercicio 
                                      ,x13_descricao 
                       )
                values (
                                $this->x13_sequencial 
                               ,$this->x13_exercicio 
                               ,'$this->x13_descricao' 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Categoria de Consumo ($this->x13_sequencial) n?o Inclu?do. Inclus?o Abortada.";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Categoria de Consumo j? Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Categoria de Consumo ($this->x13_sequencial) n?o Inclu?do. Inclus?o Abortada.";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclus?o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->x13_sequencial;
     $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->x13_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,22042,'$this->x13_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,3969,22042,'','".AddSlashes(pg_result($resaco,0,'x13_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3969,22043,'','".AddSlashes(pg_result($resaco,0,'x13_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3969,22044,'','".AddSlashes(pg_result($resaco,0,'x13_descricao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   public function alterar ($x13_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update aguacategoriaconsumo set ";
     $virgula = "";
     if(trim($this->x13_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["x13_sequencial"])){ 
       $sql  .= $virgula." x13_sequencial = $this->x13_sequencial ";
       $virgula = ",";
       if(trim($this->x13_sequencial) == null ){ 
         $this->erro_sql = " Campo C?digo n?o informado.";
         $this->erro_campo = "x13_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->x13_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["x13_exercicio"])){ 
       $sql  .= $virgula." x13_exercicio = $this->x13_exercicio ";
       $virgula = ",";
       if(trim($this->x13_exercicio) == null ){ 
         $this->erro_sql = " Campo Exerc?cio n?o informado.";
         $this->erro_campo = "x13_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->x13_descricao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["x13_descricao"])){ 
       $sql  .= $virgula." x13_descricao = '$this->x13_descricao' ";
       $virgula = ",";
       if(trim($this->x13_descricao) == null ){ 
         $this->erro_sql = " Campo Descri??o n?o informado.";
         $this->erro_campo = "x13_descricao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($x13_sequencial!=null){
       $sql .= " x13_sequencial = $this->x13_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->x13_sequencial));
       if ($this->numrows > 0) {

         for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,22042,'$this->x13_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["x13_sequencial"]) || $this->x13_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,3969,22042,'".AddSlashes(pg_result($resaco,$conresaco,'x13_sequencial'))."','$this->x13_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["x13_exercicio"]) || $this->x13_exercicio != "")
             $resac = db_query("insert into db_acount values($acount,3969,22043,'".AddSlashes(pg_result($resaco,$conresaco,'x13_exercicio'))."','$this->x13_exercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["x13_descricao"]) || $this->x13_descricao != "")
             $resac = db_query("insert into db_acount values($acount,3969,22044,'".AddSlashes(pg_result($resaco,$conresaco,'x13_descricao'))."','$this->x13_descricao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if (!$result) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Categoria de Consumo n?o Alterado. Altera??o Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->x13_sequencial;
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result) == 0) {
         $this->erro_banco = "";
         $this->erro_sql = "Categoria de Consumo n?o foi Alterado. Altera??o Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->x13_sequencial;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Altera??o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->x13_sequencial;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   public function excluir ($x13_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if (empty($dbwhere)) {

         $resaco = $this->sql_record($this->sql_query_file($x13_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,22042,'$x13_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,3969,22042,'','".AddSlashes(pg_result($resaco,$iresaco,'x13_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,3969,22043,'','".AddSlashes(pg_result($resaco,$iresaco,'x13_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,3969,22044,'','".AddSlashes(pg_result($resaco,$iresaco,'x13_descricao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from aguacategoriaconsumo
                    where ";
     $sql2 = "";
     if (empty($dbwhere)) {
        if (!empty($x13_sequencial)){
          if (!empty($sql2)) {
            $sql2 .= " and ";
          }
          $sql2 .= " x13_sequencial = $x13_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result == false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Categoria de Consumo n?o Exclu?do. Exclus?o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$x13_sequencial;
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result) == 0) {
         $this->erro_banco = "";
         $this->erro_sql = "Categoria de Consumo n?o Encontrado. Exclus?o n?o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$x13_sequencial;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclus?o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$x13_sequencial;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   public function sql_record($sql) { 
     $result = db_query($sql);
     if (!$result) {
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_num_rows($result);
      if ($this->numrows == 0) {
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:aguacategoriaconsumo";
        $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   public function sql_query ($x13_sequencial = null,$campos = "*", $ordem = null, $dbwhere = "") { 

     $sql  = "select {$campos}";
     $sql .= "  from aguacategoriaconsumo ";
     $sql2 = "";
     if (empty($dbwhere)) {
       if (!empty($x13_sequencial)) {
         $sql2 .= " where aguacategoriaconsumo.x13_sequencial = $x13_sequencial "; 
       } 
     } else if (!empty($dbwhere)) {
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if (!empty($ordem)) {
       $sql .= " order by {$ordem}";
     }
     return $sql;
  }
   // funcao do sql 
   public function sql_query_file ($x13_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "") {

     $sql  = "select {$campos} ";
     $sql .= "  from aguacategoriaconsumo ";
     $sql2 = "";
     if (empty($dbwhere)) {
       if (!empty($x13_sequencial)){
         $sql2 .= " where aguacategoriaconsumo.x13_sequencial = $x13_sequencial "; 
       } 
     } else if (!empty($dbwhere)) {
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if (!empty($ordem)) {
       $sql .= " order by {$ordem}";
     }
     return $sql;
  }

}
