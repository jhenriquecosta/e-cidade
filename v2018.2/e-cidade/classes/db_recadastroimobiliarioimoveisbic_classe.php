<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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

//MODULO: integracaoexterna
//CLASSE DA ENTIDADE recadastroimobiliarioimoveisbic
class cl_recadastroimobiliarioimoveisbic { 
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
   var $ie29_sequencial = 0; 
   var $ie29_arquivobic = 0; 
   var $ie29_iptubase = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 ie29_sequencial = int8 = C?digo 
                 ie29_arquivobic = oid = Arquivo Bic 
                 ie29_iptubase = int4 = Matr?cula do Im?vel 
                 ";
   //funcao construtor da classe 
   function cl_recadastroimobiliarioimoveisbic() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("recadastroimobiliarioimoveisbic"); 
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
       $this->ie29_sequencial = ($this->ie29_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ie29_sequencial"]:$this->ie29_sequencial);
       $this->ie29_arquivobic = ($this->ie29_arquivobic == ""?@$GLOBALS["HTTP_POST_VARS"]["ie29_arquivobic"]:$this->ie29_arquivobic);
       $this->ie29_iptubase = ($this->ie29_iptubase == ""?@$GLOBALS["HTTP_POST_VARS"]["ie29_iptubase"]:$this->ie29_iptubase);
     }else{
       $this->ie29_sequencial = ($this->ie29_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ie29_sequencial"]:$this->ie29_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($ie29_sequencial){ 
      $this->atualizacampos();
     if($this->ie29_arquivobic == null ){ 
       $this->erro_sql = " Campo Arquivo Bic nao Informado.";
       $this->erro_campo = "ie29_arquivobic";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ie29_iptubase == null ){ 
       $this->erro_sql = " Campo Matr?cula do Im?vel nao Informado.";
       $this->erro_campo = "ie29_iptubase";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($ie29_sequencial == "" || $ie29_sequencial == null ){
       $result = db_query("select nextval('recadastroimobiliarioimoveisbic_ie29_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: recadastroimobiliarioimoveisbic_ie29_sequencial_seq do campo: ie29_sequencial"; 
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->ie29_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from recadastroimobiliarioimoveisbic_ie29_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $ie29_sequencial)){
         $this->erro_sql = " Campo ie29_sequencial maior que ?ltimo n?mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n?mero.";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->ie29_sequencial = $ie29_sequencial; 
       }
     }
     if(($this->ie29_sequencial == null) || ($this->ie29_sequencial == "") ){ 
       $this->erro_sql = " Campo ie29_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into recadastroimobiliarioimoveisbic(
                                       ie29_sequencial 
                                      ,ie29_arquivobic 
                                      ,ie29_iptubase 
                       )
                values (
                                $this->ie29_sequencial 
                               ,$this->ie29_arquivobic 
                               ,$this->ie29_iptubase 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "recadastroimobiliarioimoveisbic ($this->ie29_sequencial) nao Inclu?do. Inclusao Abortada.";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "recadastroimobiliarioimoveisbic j? Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "recadastroimobiliarioimoveisbic ($this->ie29_sequencial) nao Inclu?do. Inclusao Abortada.";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ie29_sequencial;
     $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->ie29_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,19517,'$this->ie29_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,3468,19517,'','".AddSlashes(pg_result($resaco,0,'ie29_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3468,19519,'','".AddSlashes(pg_result($resaco,0,'ie29_arquivobic'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3468,19520,'','".AddSlashes(pg_result($resaco,0,'ie29_iptubase'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($ie29_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update recadastroimobiliarioimoveisbic set ";
     $virgula = "";
     if(trim($this->ie29_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ie29_sequencial"])){ 
       $sql  .= $virgula." ie29_sequencial = $this->ie29_sequencial ";
       $virgula = ",";
       if(trim($this->ie29_sequencial) == null ){ 
         $this->erro_sql = " Campo C?digo nao Informado.";
         $this->erro_campo = "ie29_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ie29_arquivobic)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ie29_arquivobic"])){ 
       $sql  .= $virgula." ie29_arquivobic = $this->ie29_arquivobic ";
       $virgula = ",";
       if(trim($this->ie29_arquivobic) == null ){ 
         $this->erro_sql = " Campo Arquivo Bic nao Informado.";
         $this->erro_campo = "ie29_arquivobic";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ie29_iptubase)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ie29_iptubase"])){ 
       $sql  .= $virgula." ie29_iptubase = $this->ie29_iptubase ";
       $virgula = ",";
       if(trim($this->ie29_iptubase) == null ){ 
         $this->erro_sql = " Campo Matr?cula do Im?vel nao Informado.";
         $this->erro_campo = "ie29_iptubase";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($ie29_sequencial!=null){
       $sql .= " ie29_sequencial = $this->ie29_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->ie29_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,19517,'$this->ie29_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["ie29_sequencial"]) || $this->ie29_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,3468,19517,'".AddSlashes(pg_result($resaco,$conresaco,'ie29_sequencial'))."','$this->ie29_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["ie29_arquivobic"]) || $this->ie29_arquivobic != "")
           $resac = db_query("insert into db_acount values($acount,3468,19519,'".AddSlashes(pg_result($resaco,$conresaco,'ie29_arquivobic'))."','$this->ie29_arquivobic',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["ie29_iptubase"]) || $this->ie29_iptubase != "")
           $resac = db_query("insert into db_acount values($acount,3468,19520,'".AddSlashes(pg_result($resaco,$conresaco,'ie29_iptubase'))."','$this->ie29_iptubase',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "recadastroimobiliarioimoveisbic nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->ie29_sequencial;
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "recadastroimobiliarioimoveisbic nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->ie29_sequencial;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera??o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ie29_sequencial;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($ie29_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($ie29_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,19517,'$ie29_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,3468,19517,'','".AddSlashes(pg_result($resaco,$iresaco,'ie29_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3468,19519,'','".AddSlashes(pg_result($resaco,$iresaco,'ie29_arquivobic'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3468,19520,'','".AddSlashes(pg_result($resaco,$iresaco,'ie29_iptubase'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from recadastroimobiliarioimoveisbic
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($ie29_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " ie29_sequencial = $ie29_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "recadastroimobiliarioimoveisbic nao Exclu?do. Exclus?o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$ie29_sequencial;
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "recadastroimobiliarioimoveisbic nao Encontrado. Exclus?o n?o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$ie29_sequencial;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus?o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$ie29_sequencial;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   function sql_record($sql) { 
     $result = db_query($sql);
     if($result==false){
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:recadastroimobiliarioimoveisbic";
        $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $ie29_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from recadastroimobiliarioimoveisbic ";
     $sql .= "      inner join iptubase  on  iptubase.j01_matric = recadastroimobiliarioimoveisbic.ie29_iptubase";
     $sql .= "      inner join lote  on  lote.j34_idbql = iptubase.j01_idbql";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = iptubase.j01_numcgm";
     $sql2 = "";
     if($dbwhere==""){
       if($ie29_sequencial!=null ){
         $sql2 .= " where recadastroimobiliarioimoveisbic.ie29_sequencial = $ie29_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
   // funcao do sql 
   function sql_query_file ( $ie29_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from recadastroimobiliarioimoveisbic ";
     $sql2 = "";
     if($dbwhere==""){
       if($ie29_sequencial!=null ){
         $sql2 .= " where recadastroimobiliarioimoveisbic.ie29_sequencial = $ie29_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
}
?>