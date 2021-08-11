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

//MODULO: prefeitura
//CLASSE DA ENTIDADE dbprefcgmcnae
class cl_dbprefcgmcnae { 
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
   var $z01_sequencial = 0; 
   var $z01_dbprefcgm = 0; 
   var $z01_cnaeanalitica = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 z01_sequencial = int4 = C�digo sequencial 
                 z01_dbprefcgm = int4 = CGM dbpref 
                 z01_cnaeanalitica = int4 = C�digo Cnae 
                 ";
   //funcao construtor da classe 
   function cl_dbprefcgmcnae() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dbprefcgmcnae"); 
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
       $this->z01_sequencial = ($this->z01_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["z01_sequencial"]:$this->z01_sequencial);
       $this->z01_dbprefcgm = ($this->z01_dbprefcgm == ""?@$GLOBALS["HTTP_POST_VARS"]["z01_dbprefcgm"]:$this->z01_dbprefcgm);
       $this->z01_cnaeanalitica = ($this->z01_cnaeanalitica == ""?@$GLOBALS["HTTP_POST_VARS"]["z01_cnaeanalitica"]:$this->z01_cnaeanalitica);
     }else{
       $this->z01_sequencial = ($this->z01_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["z01_sequencial"]:$this->z01_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($z01_sequencial){ 
      $this->atualizacampos();
     if($this->z01_dbprefcgm == null ){ 
       $this->erro_sql = " Campo CGM dbpref nao Informado.";
       $this->erro_campo = "z01_dbprefcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->z01_cnaeanalitica == null ){ 
       $this->erro_sql = " Campo C�digo Cnae nao Informado.";
       $this->erro_campo = "z01_cnaeanalitica";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($z01_sequencial == "" || $z01_sequencial == null ){
       $result = db_query("select nextval('dbprefcgmcnae_z01_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dbprefcgmcnae_z01_sequencial_seq do campo: z01_sequencial"; 
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->z01_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from dbprefcgmcnae_z01_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $z01_sequencial)){
         $this->erro_sql = " Campo z01_sequencial maior que �ltimo n�mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n�mero.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->z01_sequencial = $z01_sequencial; 
       }
     }
     if(($this->z01_sequencial == null) || ($this->z01_sequencial == "") ){ 
       $this->erro_sql = " Campo z01_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dbprefcgmcnae(
                                       z01_sequencial 
                                      ,z01_dbprefcgm 
                                      ,z01_cnaeanalitica 
                       )
                values (
                                $this->z01_sequencial 
                               ,$this->z01_dbprefcgm 
                               ,$this->z01_cnaeanalitica 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dbprefcgmcnae ($this->z01_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dbprefcgmcnae j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dbprefcgmcnae ($this->z01_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->z01_sequencial;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->z01_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,10200,'$this->z01_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,1759,10200,'','".AddSlashes(pg_result($resaco,0,'z01_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1759,10227,'','".AddSlashes(pg_result($resaco,0,'z01_dbprefcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1759,10203,'','".AddSlashes(pg_result($resaco,0,'z01_cnaeanalitica'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($z01_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dbprefcgmcnae set ";
     $virgula = "";
     if(trim($this->z01_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["z01_sequencial"])){ 
       $sql  .= $virgula." z01_sequencial = $this->z01_sequencial ";
       $virgula = ",";
       if(trim($this->z01_sequencial) == null ){ 
         $this->erro_sql = " Campo C�digo sequencial nao Informado.";
         $this->erro_campo = "z01_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->z01_dbprefcgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["z01_dbprefcgm"])){ 
       $sql  .= $virgula." z01_dbprefcgm = $this->z01_dbprefcgm ";
       $virgula = ",";
       if(trim($this->z01_dbprefcgm) == null ){ 
         $this->erro_sql = " Campo CGM dbpref nao Informado.";
         $this->erro_campo = "z01_dbprefcgm";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->z01_cnaeanalitica)!="" || isset($GLOBALS["HTTP_POST_VARS"]["z01_cnaeanalitica"])){ 
       $sql  .= $virgula." z01_cnaeanalitica = $this->z01_cnaeanalitica ";
       $virgula = ",";
       if(trim($this->z01_cnaeanalitica) == null ){ 
         $this->erro_sql = " Campo C�digo Cnae nao Informado.";
         $this->erro_campo = "z01_cnaeanalitica";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($z01_sequencial!=null){
       $sql .= " z01_sequencial = $this->z01_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->z01_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,10200,'$this->z01_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["z01_sequencial"]))
           $resac = db_query("insert into db_acount values($acount,1759,10200,'".AddSlashes(pg_result($resaco,$conresaco,'z01_sequencial'))."','$this->z01_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["z01_dbprefcgm"]))
           $resac = db_query("insert into db_acount values($acount,1759,10227,'".AddSlashes(pg_result($resaco,$conresaco,'z01_dbprefcgm'))."','$this->z01_dbprefcgm',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["z01_cnaeanalitica"]))
           $resac = db_query("insert into db_acount values($acount,1759,10203,'".AddSlashes(pg_result($resaco,$conresaco,'z01_cnaeanalitica'))."','$this->z01_cnaeanalitica',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dbprefcgmcnae nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->z01_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dbprefcgmcnae nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->z01_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->z01_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($z01_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($z01_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,10200,'$z01_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,1759,10200,'','".AddSlashes(pg_result($resaco,$iresaco,'z01_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1759,10227,'','".AddSlashes(pg_result($resaco,$iresaco,'z01_dbprefcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1759,10203,'','".AddSlashes(pg_result($resaco,$iresaco,'z01_cnaeanalitica'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from dbprefcgmcnae
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($z01_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " z01_sequencial = $z01_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dbprefcgmcnae nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$z01_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dbprefcgmcnae nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$z01_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$z01_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dbprefcgmcnae";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   function sql_query ( $z01_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dbprefcgmcnae ";
     $sql .= "      inner join cnaeanalitica  on  cnaeanalitica.q72_sequencial = dbprefcgmcnae.z01_cnaeanalitica";
     $sql .= "      inner join dbprefcgm  on  dbprefcgm.z01_sequencial = dbprefcgmcnae.z01_dbprefcgm";
     $sql .= "      inner join cnae  on  cnae.q71_sequencial = cnaeanalitica.q72_cnae";
     $sql2 = "";
     if($dbwhere==""){
       if($z01_sequencial!=null ){
         $sql2 .= " where dbprefcgmcnae.z01_sequencial = $z01_sequencial "; 
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
   function sql_query_file ( $z01_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dbprefcgmcnae ";
     $sql2 = "";
     if($dbwhere==""){
       if($z01_sequencial!=null ){
         $sql2 .= " where dbprefcgmcnae.z01_sequencial = $z01_sequencial "; 
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