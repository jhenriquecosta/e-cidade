<?
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

//MODULO: protocolo
//CLASSE DA ENTIDADE arqproc
class cl_arqproc { 
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
   var $p68_codarquiv = 0; 
   var $p68_codproc = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 p68_codarquiv = int4 = C�digo do Arquivamento 
                 p68_codproc = int4 = Processo 
                 ";
   //funcao construtor da classe 
   function cl_arqproc() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("arqproc"); 
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
       $this->p68_codarquiv = ($this->p68_codarquiv == ""?@$GLOBALS["HTTP_POST_VARS"]["p68_codarquiv"]:$this->p68_codarquiv);
       $this->p68_codproc = ($this->p68_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["p68_codproc"]:$this->p68_codproc);
     }else{
       $this->p68_codarquiv = ($this->p68_codarquiv == ""?@$GLOBALS["HTTP_POST_VARS"]["p68_codarquiv"]:$this->p68_codarquiv);
       $this->p68_codproc = ($this->p68_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["p68_codproc"]:$this->p68_codproc);
     }
   }
   // funcao para inclusao
   function incluir ($p68_codarquiv,$p68_codproc){ 
       $this->atualizacampos();
       $this->p68_codarquiv = $p68_codarquiv; 
       $this->p68_codproc = $p68_codproc; 
     if(($this->p68_codarquiv == null) || ($this->p68_codarquiv == "") ){ 
       $this->erro_sql = " Campo p68_codarquiv nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->p68_codproc == null) || ($this->p68_codproc == "") ){ 
       $this->erro_sql = " Campo p68_codproc nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into arqproc(
                                       p68_codarquiv 
                                      ,p68_codproc 
                       )
                values (
                                $this->p68_codarquiv 
                               ,$this->p68_codproc 
                      )";
                           
     $result = db_query($sql); 
     
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Reabertura de Processos ($this->p68_codarquiv."-".$this->p68_codproc) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Reabertura de Processos j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Reabertura de Processos ($this->p68_codarquiv."-".$this->p68_codproc) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p68_codarquiv."-".$this->p68_codproc;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->p68_codarquiv,$this->p68_codproc));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,4675,'$this->p68_codarquiv','I')");
       $resac = db_query("insert into db_acountkey values($acount,4676,'$this->p68_codproc','I')");
       $resac = db_query("insert into db_acount values($acount,614,4675,'','".AddSlashes(pg_result($resaco,0,'p68_codarquiv'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,614,4676,'','".AddSlashes(pg_result($resaco,0,'p68_codproc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($p68_codarquiv=null,$p68_codproc=null) { 
      $this->atualizacampos();
     $sql = " update arqproc set ";
     $virgula = "";
     if(trim($this->p68_codarquiv)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p68_codarquiv"])){ 
       $sql  .= $virgula." p68_codarquiv = $this->p68_codarquiv ";
       $virgula = ",";
       if(trim($this->p68_codarquiv) == null ){ 
         $this->erro_sql = " Campo C�digo do Arquivamento nao Informado.";
         $this->erro_campo = "p68_codarquiv";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->p68_codproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p68_codproc"])){ 
       $sql  .= $virgula." p68_codproc = $this->p68_codproc ";
       $virgula = ",";
       if(trim($this->p68_codproc) == null ){ 
         $this->erro_sql = " Campo Processo nao Informado.";
         $this->erro_campo = "p68_codproc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($p68_codarquiv!=null){
       $sql .= " p68_codarquiv = $this->p68_codarquiv";
     }
     if($p68_codproc!=null){
       $sql .= " and  p68_codproc = $this->p68_codproc";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->p68_codarquiv,$this->p68_codproc));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,4675,'$this->p68_codarquiv','A')");
         $resac = db_query("insert into db_acountkey values($acount,4676,'$this->p68_codproc','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["p68_codarquiv"]))
           $resac = db_query("insert into db_acount values($acount,614,4675,'".AddSlashes(pg_result($resaco,$conresaco,'p68_codarquiv'))."','$this->p68_codarquiv',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["p68_codproc"]))
           $resac = db_query("insert into db_acount values($acount,614,4676,'".AddSlashes(pg_result($resaco,$conresaco,'p68_codproc'))."','$this->p68_codproc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Reabertura de Processos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->p68_codarquiv."-".$this->p68_codproc;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Reabertura de Processos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->p68_codarquiv."-".$this->p68_codproc;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p68_codarquiv."-".$this->p68_codproc;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($p68_codarquiv=null,$p68_codproc=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($p68_codarquiv,$p68_codproc));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,4675,'$p68_codarquiv','E')");
         $resac = db_query("insert into db_acountkey values($acount,4676,'$p68_codproc','E')");
         $resac = db_query("insert into db_acount values($acount,614,4675,'','".AddSlashes(pg_result($resaco,$iresaco,'p68_codarquiv'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,614,4676,'','".AddSlashes(pg_result($resaco,$iresaco,'p68_codproc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from arqproc
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($p68_codarquiv != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " p68_codarquiv = $p68_codarquiv ";
        }
        if($p68_codproc != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " p68_codproc = $p68_codproc ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Reabertura de Processos nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$p68_codarquiv."-".$p68_codproc;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Reabertura de Processos nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$p68_codarquiv."-".$p68_codproc;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$p68_codarquiv."-".$p68_codproc;
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
        $this->erro_sql   = "Record Vazio na Tabela:arqproc";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $p68_codarquiv=null,$p68_codproc=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from arqproc ";
     $sql2 = "";
     if($dbwhere==""){
       if($p68_codarquiv!=null ){
         $sql2 .= " where arqproc.p68_codarquiv = $p68_codarquiv "; 
       } 
       if($p68_codproc!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " arqproc.p68_codproc = $p68_codproc "; 
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
   function sql_query_file ( $p68_codarquiv=null,$p68_codproc=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from arqproc ";
     $sql2 = "";
     if($dbwhere==""){
       if($p68_codarquiv!=null ){
         $sql2 .= " where arqproc.p68_codarquiv = $p68_codarquiv "; 
       } 
       if($p68_codproc!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " arqproc.p68_codproc = $p68_codproc "; 
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
  
   function sql_query_consprocarquiv ( $p68_codarquiv=null,$p68_codproc=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from arqproc                                                ";
     $sql .= "      inner join procarquiv on p68_codarquiv = p67_codarquiv ";
     $sql2 = "                                                             ";
     if($dbwhere==""){
       if($p68_codarquiv!=null ){
         $sql2 .= " where arqproc.p68_codarquiv = $p68_codarquiv "; 
       } 
       if($p68_codproc!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " arqproc.p68_codproc = $p68_codproc "; 
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