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

//MODULO: veiculos
//CLASSE DA ENTIDADE veiccadcategcnh
class cl_veiccadcategcnh { 
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
   var $ve30_codigo = 0; 
   var $ve30_descr = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 ve30_codigo = int4 = Codigo Categoria CNH 
                 ve30_descr = varchar(40) = Descri??o Categoria CNH 
                 ";
   //funcao construtor da classe 
   function cl_veiccadcategcnh() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("veiccadcategcnh"); 
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
       $this->ve30_codigo = ($this->ve30_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["ve30_codigo"]:$this->ve30_codigo);
       $this->ve30_descr = ($this->ve30_descr == ""?@$GLOBALS["HTTP_POST_VARS"]["ve30_descr"]:$this->ve30_descr);
     }else{
       $this->ve30_codigo = ($this->ve30_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["ve30_codigo"]:$this->ve30_codigo);
     }
   }
   // funcao para inclusao
   function incluir ($ve30_codigo){ 
      $this->atualizacampos();
     if($this->ve30_descr == null ){ 
       $this->erro_sql = " Campo Descri??o Categoria CNH nao Informado.";
       $this->erro_campo = "ve30_descr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($ve30_codigo == "" || $ve30_codigo == null ){
       $result = db_query("select nextval('veiccadcategcnh_ve30_codigo_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: veiccadcategcnh_ve30_codigo_seq do campo: ve30_codigo"; 
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->ve30_codigo = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from veiccadcategcnh_ve30_codigo_seq");
       if(($result != false) && (pg_result($result,0,0) < $ve30_codigo)){
         $this->erro_sql = " Campo ve30_codigo maior que ?ltimo n?mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n?mero.";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->ve30_codigo = $ve30_codigo; 
       }
     }
     if(($this->ve30_codigo == null) || ($this->ve30_codigo == "") ){ 
       $this->erro_sql = " Campo ve30_codigo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into veiccadcategcnh(
                                       ve30_codigo 
                                      ,ve30_descr 
                       )
                values (
                                $this->ve30_codigo 
                               ,'$this->ve30_descr' 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Cadastro de Categorias CNH ($this->ve30_codigo) nao Inclu?do. Inclusao Abortada.";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Cadastro de Categorias CNH j? Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Cadastro de Categorias CNH ($this->ve30_codigo) nao Inclu?do. Inclusao Abortada.";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ve30_codigo;
     $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->ve30_codigo));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,9236,'$this->ve30_codigo','I')");
       $resac = db_query("insert into db_acount values($acount,1583,9236,'','".AddSlashes(pg_result($resaco,0,'ve30_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1583,9237,'','".AddSlashes(pg_result($resaco,0,'ve30_descr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($ve30_codigo=null) { 
      $this->atualizacampos();
     $sql = " update veiccadcategcnh set ";
     $virgula = "";
     if(trim($this->ve30_codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve30_codigo"])){ 
       $sql  .= $virgula." ve30_codigo = $this->ve30_codigo ";
       $virgula = ",";
       if(trim($this->ve30_codigo) == null ){ 
         $this->erro_sql = " Campo Codigo Categoria CNH nao Informado.";
         $this->erro_campo = "ve30_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ve30_descr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ve30_descr"])){ 
       $sql  .= $virgula." ve30_descr = '$this->ve30_descr' ";
       $virgula = ",";
       if(trim($this->ve30_descr) == null ){ 
         $this->erro_sql = " Campo Descri??o Categoria CNH nao Informado.";
         $this->erro_campo = "ve30_descr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($ve30_codigo!=null){
       $sql .= " ve30_codigo = $this->ve30_codigo";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->ve30_codigo));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,9236,'$this->ve30_codigo','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["ve30_codigo"]))
           $resac = db_query("insert into db_acount values($acount,1583,9236,'".AddSlashes(pg_result($resaco,$conresaco,'ve30_codigo'))."','$this->ve30_codigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["ve30_descr"]))
           $resac = db_query("insert into db_acount values($acount,1583,9237,'".AddSlashes(pg_result($resaco,$conresaco,'ve30_descr'))."','$this->ve30_descr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro de Categorias CNH nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->ve30_codigo;
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro de Categorias CNH nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->ve30_codigo;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera??o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ve30_codigo;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($ve30_codigo=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($ve30_codigo));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,9236,'$ve30_codigo','E')");
         $resac = db_query("insert into db_acount values($acount,1583,9236,'','".AddSlashes(pg_result($resaco,$iresaco,'ve30_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1583,9237,'','".AddSlashes(pg_result($resaco,$iresaco,'ve30_descr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from veiccadcategcnh
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($ve30_codigo != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " ve30_codigo = $ve30_codigo ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro de Categorias CNH nao Exclu?do. Exclus?o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$ve30_codigo;
       $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro de Categorias CNH nao Encontrado. Exclus?o n?o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$ve30_codigo;
         $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus?o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$ve30_codigo;
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
        $this->erro_sql   = "Record Vazio na Tabela:veiccadcategcnh";
        $this->erro_msg   = "Usu?rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   function sql_query ( $ve30_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from veiccadcategcnh ";
     $sql2 = "";
     if($dbwhere==""){
       if($ve30_codigo!=null ){
         $sql2 .= " where veiccadcategcnh.ve30_codigo = $ve30_codigo "; 
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
   function sql_query_file ( $ve30_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from veiccadcategcnh ";
     $sql2 = "";
     if($dbwhere==""){
       if($ve30_codigo!=null ){
         $sql2 .= " where veiccadcategcnh.ve30_codigo = $ve30_codigo "; 
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