<?
//MODULO: recursoshumanos
//CLASSE DA ENTIDADE rhferiasperiodoassentamento
class cl_rhferiasperiodoassentamento { 
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
   var $rh169_sequencial = 0; 
   var $rh169_rhferiasperiodo = 0; 
   var $rh169_assenta = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 rh169_sequencial = int4 = C?digo Sequencial 
                 rh169_rhferiasperiodo = int4 = Periodo de Gozo 
                 rh169_assenta = int4 = Assentamento 
                 ";
   //funcao construtor da classe 
   function cl_rhferiasperiodoassentamento() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("rhferiasperiodoassentamento"); 
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
       $this->rh169_sequencial = ($this->rh169_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh169_sequencial"]:$this->rh169_sequencial);
       $this->rh169_rhferiasperiodo = ($this->rh169_rhferiasperiodo == ""?@$GLOBALS["HTTP_POST_VARS"]["rh169_rhferiasperiodo"]:$this->rh169_rhferiasperiodo);
       $this->rh169_assenta = ($this->rh169_assenta == ""?@$GLOBALS["HTTP_POST_VARS"]["rh169_assenta"]:$this->rh169_assenta);
     }else{
       $this->rh169_sequencial = ($this->rh169_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh169_sequencial"]:$this->rh169_sequencial);
     }
   }
   // funcao para Inclus?o
   function incluir ($rh169_sequencial){ 
      $this->atualizacampos();
     if($this->rh169_rhferiasperiodo == null ){ 
       $this->erro_sql = " Campo Periodo de Gozo n?o informado.";
       $this->erro_campo = "rh169_rhferiasperiodo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->rh169_assenta == null ){ 
       $this->erro_sql = " Campo Assentamento n?o informado.";
       $this->erro_campo = "rh169_assenta";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($rh169_sequencial == "" || $rh169_sequencial == null ){
       $result = db_query("select nextval('rhferiasperiodoassentamento_rh169_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rhferiasperiodoassentamento_rh169_sequencial_seq do campo: rh169_sequencial"; 
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->rh169_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from rhferiasperiodoassentamento_rh169_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $rh169_sequencial)){
         $this->erro_sql = " Campo rh169_sequencial maior que ?ltimo n?mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n?mero.";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->rh169_sequencial = $rh169_sequencial; 
       }
     }
     if(($this->rh169_sequencial == null) || ($this->rh169_sequencial == "") ){ 
       $this->erro_sql = " Campo rh169_sequencial n?o declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rhferiasperiodoassentamento(
                                       rh169_sequencial 
                                      ,rh169_rhferiasperiodo 
                                      ,rh169_assenta 
                       )
                values (
                                $this->rh169_sequencial 
                               ,$this->rh169_rhferiasperiodo 
                               ,$this->rh169_assenta 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Assentamos do Periodo de gozo ($this->rh169_sequencial) n?o Inclu?do. Inclus?o Abortada.";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Assentamos do Periodo de gozo j? Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Assentamos do Periodo de gozo ($this->rh169_sequencial) n?o Inclu?do. Inclus?o Abortada.";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclus?o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh169_sequencial;
     $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh169_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,21576,'$this->rh169_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,3873,21576,'','".AddSlashes(pg_result($resaco,0,'rh169_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3873,21577,'','".AddSlashes(pg_result($resaco,0,'rh169_rhferiasperiodo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3873,21578,'','".AddSlashes(pg_result($resaco,0,'rh169_assenta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   public function alterar ($rh169_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update rhferiasperiodoassentamento set ";
     $virgula = "";
     if(trim($this->rh169_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh169_sequencial"])){ 
       $sql  .= $virgula." rh169_sequencial = $this->rh169_sequencial ";
       $virgula = ",";
       if(trim($this->rh169_sequencial) == null ){ 
         $this->erro_sql = " Campo C?digo Sequencial n?o informado.";
         $this->erro_campo = "rh169_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->rh169_rhferiasperiodo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh169_rhferiasperiodo"])){ 
       $sql  .= $virgula." rh169_rhferiasperiodo = $this->rh169_rhferiasperiodo ";
       $virgula = ",";
       if(trim($this->rh169_rhferiasperiodo) == null ){ 
         $this->erro_sql = " Campo Periodo de Gozo n?o informado.";
         $this->erro_campo = "rh169_rhferiasperiodo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->rh169_assenta)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh169_assenta"])){ 
       $sql  .= $virgula." rh169_assenta = $this->rh169_assenta ";
       $virgula = ",";
       if(trim($this->rh169_assenta) == null ){ 
         $this->erro_sql = " Campo Assentamento n?o informado.";
         $this->erro_campo = "rh169_assenta";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($rh169_sequencial!=null){
       $sql .= " rh169_sequencial = $this->rh169_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh169_sequencial));
       if ($this->numrows > 0) {

         for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,21576,'$this->rh169_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh169_sequencial"]) || $this->rh169_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,3873,21576,'".AddSlashes(pg_result($resaco,$conresaco,'rh169_sequencial'))."','$this->rh169_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh169_rhferiasperiodo"]) || $this->rh169_rhferiasperiodo != "")
             $resac = db_query("insert into db_acount values($acount,3873,21577,'".AddSlashes(pg_result($resaco,$conresaco,'rh169_rhferiasperiodo'))."','$this->rh169_rhferiasperiodo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh169_assenta"]) || $this->rh169_assenta != "")
             $resac = db_query("insert into db_acount values($acount,3873,21578,'".AddSlashes(pg_result($resaco,$conresaco,'rh169_assenta'))."','$this->rh169_assenta',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if (!$result) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Assentamos do Periodo de gozo n?o Alterado. Altera??o Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh169_sequencial;
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result) == 0) {
         $this->erro_banco = "";
         $this->erro_sql = "Assentamos do Periodo de gozo n?o foi Alterado. Altera??o Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh169_sequencial;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Altera??o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh169_sequencial;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   public function excluir ($rh169_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if (empty($dbwhere)) {

         $resaco = $this->sql_record($this->sql_query_file($rh169_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,21576,'$rh169_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,3873,21576,'','".AddSlashes(pg_result($resaco,$iresaco,'rh169_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,3873,21577,'','".AddSlashes(pg_result($resaco,$iresaco,'rh169_rhferiasperiodo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,3873,21578,'','".AddSlashes(pg_result($resaco,$iresaco,'rh169_assenta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from rhferiasperiodoassentamento
                    where ";
     $sql2 = "";
     if (empty($dbwhere)) {
        if (!empty($rh169_sequencial)){
          if (!empty($sql2)) {
            $sql2 .= " and ";
          }
          $sql2 .= " rh169_sequencial = $rh169_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result == false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Assentamos do Periodo de gozo n?o Exclu?do. Exclus?o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$rh169_sequencial;
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result) == 0) {
         $this->erro_banco = "";
         $this->erro_sql = "Assentamos do Periodo de gozo n?o Encontrado. Exclus?o n?o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$rh169_sequencial;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclus?o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$rh169_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:rhferiasperiodoassentamento";
        $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   public function sql_query ($rh169_sequencial = null,$campos = "*", $ordem = null, $dbwhere = "") { 

     $sql  = "select {$campos}";
     $sql .= "  from rhferiasperiodoassentamento ";
     $sql .= "      inner join assenta  on  assenta.h16_codigo = rhferiasperiodoassentamento.rh169_assenta";
     $sql .= "      inner join rhferiasperiodo  on  rhferiasperiodo.rh110_sequencial = rhferiasperiodoassentamento.rh169_rhferiasperiodo";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = assenta.h16_login";
     $sql .= "      inner join tipoasse  on  tipoasse.h12_codigo = assenta.h16_assent";
     $sql .= "      inner join rhpessoal  on  rhpessoal.rh01_regist = assenta.h16_regist";
     $sql .= "      inner join rhferias  as a on   a.rh109_sequencial = rhferiasperiodo.rh110_rhferias";
     $sql2 = "";
     if (empty($dbwhere)) {
       if (!empty($rh169_sequencial)) {
         $sql2 .= " where rhferiasperiodoassentamento.rh169_sequencial = $rh169_sequencial "; 
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
   public function sql_query_file ($rh169_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "") {

     $sql  = "select {$campos} ";
     $sql .= "  from rhferiasperiodoassentamento ";
     $sql2 = "";
     if (empty($dbwhere)) {
       if (!empty($rh169_sequencial)){
         $sql2 .= " where rhferiasperiodoassentamento.rh169_sequencial = $rh169_sequencial "; 
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
