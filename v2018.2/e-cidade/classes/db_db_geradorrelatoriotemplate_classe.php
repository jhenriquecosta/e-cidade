<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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

//MODULO: configuracoes
//CLASSE DA ENTIDADE db_geradorrelatoriotemplate
class cl_db_geradorrelatoriotemplate { 
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
   var $db15_sequencial = 0; 
   var $db15_db_relatorio = 0; 
   var $db15_documento = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 db15_sequencial = int4 = Sequencial 
                 db15_db_relatorio = int4 = C�digo do relat�rio 
                 db15_documento = oid = Documento 
                 ";
   //funcao construtor da classe 
   function cl_db_geradorrelatoriotemplate() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("db_geradorrelatoriotemplate"); 
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
       $this->db15_sequencial = ($this->db15_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["db15_sequencial"]:$this->db15_sequencial);
       $this->db15_db_relatorio = ($this->db15_db_relatorio == ""?@$GLOBALS["HTTP_POST_VARS"]["db15_db_relatorio"]:$this->db15_db_relatorio);
       $this->db15_documento = ($this->db15_documento == ""?@$GLOBALS["HTTP_POST_VARS"]["db15_documento"]:$this->db15_documento);
     }else{
       $this->db15_sequencial = ($this->db15_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["db15_sequencial"]:$this->db15_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($db15_sequencial){ 
      $this->atualizacampos();
     if($this->db15_db_relatorio == null ){ 
       $this->erro_sql = " Campo C�digo do relat�rio nao Informado.";
       $this->erro_campo = "db15_db_relatorio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->db15_documento == null ){ 
       $this->erro_sql = " Campo Documento nao Informado.";
       $this->erro_campo = "db15_documento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($db15_sequencial == "" || $db15_sequencial == null ){
       $result = db_query("select nextval('db_geradorrelatoriotemplate_db15_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: db_geradorrelatoriotemplate_db15_sequencial_seq do campo: db15_sequencial"; 
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->db15_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from db_geradorrelatoriotemplate_db15_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $db15_sequencial)){
         $this->erro_sql = " Campo db15_sequencial maior que �ltimo n�mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n�mero.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->db15_sequencial = $db15_sequencial; 
       }
     }
     if(($this->db15_sequencial == null) || ($this->db15_sequencial == "") ){ 
       $this->erro_sql = " Campo db15_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into db_geradorrelatoriotemplate(
                                       db15_sequencial 
                                      ,db15_db_relatorio 
                                      ,db15_documento 
                       )
                values (
                                $this->db15_sequencial 
                               ,$this->db15_db_relatorio 
                               ,$this->db15_documento 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Gerador do template do relat�rio ($this->db15_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Gerador do template do relat�rio j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Gerador do template do relat�rio ($this->db15_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->db15_sequencial;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->db15_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,12283,'$this->db15_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2135,12283,'','".AddSlashes(pg_result($resaco,0,'db15_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2135,12284,'','".AddSlashes(pg_result($resaco,0,'db15_db_relatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2135,12271,'','".AddSlashes(pg_result($resaco,0,'db15_documento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($db15_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update db_geradorrelatoriotemplate set ";
     $virgula = "";
     if(trim($this->db15_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["db15_sequencial"])){ 
       $sql  .= $virgula." db15_sequencial = $this->db15_sequencial ";
       $virgula = ",";
       if(trim($this->db15_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial nao Informado.";
         $this->erro_campo = "db15_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->db15_db_relatorio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["db15_db_relatorio"])){ 
       $sql  .= $virgula." db15_db_relatorio = $this->db15_db_relatorio ";
       $virgula = ",";
       if(trim($this->db15_db_relatorio) == null ){ 
         $this->erro_sql = " Campo C�digo do relat�rio nao Informado.";
         $this->erro_campo = "db15_db_relatorio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->db15_documento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["db15_documento"])){ 
       $sql  .= $virgula." db15_documento = $this->db15_documento ";
       $virgula = ",";
       if(trim($this->db15_documento) == null ){ 
         $this->erro_sql = " Campo Documento nao Informado.";
         $this->erro_campo = "db15_documento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($db15_sequencial!=null){
       $sql .= " db15_sequencial = $this->db15_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->db15_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,12283,'$this->db15_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["db15_sequencial"]))
           $resac = db_query("insert into db_acount values($acount,2135,12283,'".AddSlashes(pg_result($resaco,$conresaco,'db15_sequencial'))."','$this->db15_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["db15_db_relatorio"]))
           $resac = db_query("insert into db_acount values($acount,2135,12284,'".AddSlashes(pg_result($resaco,$conresaco,'db15_db_relatorio'))."','$this->db15_db_relatorio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["db15_documento"]))
           $resac = db_query("insert into db_acount values($acount,2135,12271,'".AddSlashes(pg_result($resaco,$conresaco,'db15_documento'))."','$this->db15_documento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Gerador do template do relat�rio nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->db15_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Gerador do template do relat�rio nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->db15_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->db15_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($db15_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($db15_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,12283,'$db15_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2135,12283,'','".AddSlashes(pg_result($resaco,$iresaco,'db15_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2135,12284,'','".AddSlashes(pg_result($resaco,$iresaco,'db15_db_relatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2135,12271,'','".AddSlashes(pg_result($resaco,$iresaco,'db15_documento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from db_geradorrelatoriotemplate
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($db15_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " db15_sequencial = $db15_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Gerador do template do relat�rio nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$db15_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Gerador do template do relat�rio nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$db15_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$db15_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
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
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:db_geradorrelatoriotemplate";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   function sql_query ( $db15_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from db_geradorrelatoriotemplate ";
     $sql .= "      inner join db_relatorio  on  db_relatorio.db63_sequencial = db_geradorrelatoriotemplate.db15_db_relatorio";
     $sql .= "      inner join db_gruporelatorio  on  db_gruporelatorio.db13_sequencial = db_relatorio.db63_db_gruporelatorio";
     $sql .= "      inner join db_tiporelatorio  on  db_tiporelatorio.db14_sequencial = db_relatorio.db63_db_tiporelatorio";
     $sql2 = "";
     if($dbwhere==""){
       if($db15_sequencial!=null ){
         $sql2 .= " where db_geradorrelatoriotemplate.db15_sequencial = $db15_sequencial "; 
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
   function sql_query_file ( $db15_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from db_geradorrelatoriotemplate ";
     $sql2 = "";
     if($dbwhere==""){
       if($db15_sequencial!=null ){
         $sql2 .= " where db_geradorrelatoriotemplate.db15_sequencial = $db15_sequencial "; 
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