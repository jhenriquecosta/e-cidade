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

//MODULO: transito
//CLASSE DA ENTIDADE condutores
class cl_condutores { 
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
   var $tr11_id = 0; 
   var $tr11_idveiculo = 0; 
   var $tr11_dtnasc_dia = null; 
   var $tr11_dtnasc_mes = null; 
   var $tr11_dtnasc_ano = null; 
   var $tr11_dtnasc = null; 
   var $tr11_idhabilitacao = 0; 
   var $tr11_sexo = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 tr11_id = int8 = c�digo do condutor 
                 tr11_idveiculo = int8 = Veiculo 
                 tr11_dtnasc = date = Data de Nascimento 
                 tr11_idhabilitacao = int8 = Tipo de Habiliti��o 
                 tr11_sexo = varchar(15) = Sexo 
                 ";
   //funcao construtor da classe 
   function cl_condutores() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("condutores"); 
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
       $this->tr11_id = ($this->tr11_id == ""?@$GLOBALS["HTTP_POST_VARS"]["tr11_id"]:$this->tr11_id);
       $this->tr11_idveiculo = ($this->tr11_idveiculo == ""?@$GLOBALS["HTTP_POST_VARS"]["tr11_idveiculo"]:$this->tr11_idveiculo);
       if($this->tr11_dtnasc == ""){
         $this->tr11_dtnasc_dia = ($this->tr11_dtnasc_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["tr11_dtnasc_dia"]:$this->tr11_dtnasc_dia);
         $this->tr11_dtnasc_mes = ($this->tr11_dtnasc_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["tr11_dtnasc_mes"]:$this->tr11_dtnasc_mes);
         $this->tr11_dtnasc_ano = ($this->tr11_dtnasc_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["tr11_dtnasc_ano"]:$this->tr11_dtnasc_ano);
         if($this->tr11_dtnasc_dia != ""){
            $this->tr11_dtnasc = $this->tr11_dtnasc_ano."-".$this->tr11_dtnasc_mes."-".$this->tr11_dtnasc_dia;
         }
       }
       $this->tr11_idhabilitacao = ($this->tr11_idhabilitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["tr11_idhabilitacao"]:$this->tr11_idhabilitacao);
       $this->tr11_sexo = ($this->tr11_sexo == ""?@$GLOBALS["HTTP_POST_VARS"]["tr11_sexo"]:$this->tr11_sexo);
     }else{
       $this->tr11_id = ($this->tr11_id == ""?@$GLOBALS["HTTP_POST_VARS"]["tr11_id"]:$this->tr11_id);
     }
   }
   // funcao para inclusao
   function incluir ($tr11_id){ 
      $this->atualizacampos();
     if($this->tr11_idveiculo == null ){ 
       $this->erro_sql = " Campo Veiculo nao Informado.";
       $this->erro_campo = "tr11_idveiculo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->tr11_dtnasc == null ){ 
       $this->erro_sql = " Campo Data de Nascimento nao Informado.";
       $this->erro_campo = "tr11_dtnasc_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->tr11_idhabilitacao == null ){ 
       $this->erro_sql = " Campo Tipo de Habiliti��o nao Informado.";
       $this->erro_campo = "tr11_idhabilitacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->tr11_sexo == null ){ 
       $this->erro_sql = " Campo Sexo nao Informado.";
       $this->erro_campo = "tr11_sexo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($tr11_id == "" || $tr11_id == null ){
       $result = db_query("select nextval('condutores_tr11_id_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: condutores_tr11_id_seq do campo: tr11_id"; 
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->tr11_id = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from condutores_tr11_id_seq");
       if(($result != false) && (pg_result($result,0,0) < $tr11_id)){
         $this->erro_sql = " Campo tr11_id maior que �ltimo n�mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n�mero.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->tr11_id = $tr11_id; 
       }
     }
     if(($this->tr11_id == null) || ($this->tr11_id == "") ){ 
       $this->erro_sql = " Campo tr11_id nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into condutores(
                                       tr11_id 
                                      ,tr11_idveiculo 
                                      ,tr11_dtnasc 
                                      ,tr11_idhabilitacao 
                                      ,tr11_sexo 
                       )
                values (
                                $this->tr11_id 
                               ,$this->tr11_idveiculo 
                               ,".($this->tr11_dtnasc == "null" || $this->tr11_dtnasc == ""?"null":"'".$this->tr11_dtnasc."'")." 
                               ,$this->tr11_idhabilitacao 
                               ,'$this->tr11_sexo' 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Condutores dos veiculos ($this->tr11_id) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Condutores dos veiculos j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Condutores dos veiculos ($this->tr11_id) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->tr11_id;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->tr11_id));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,5652,'$this->tr11_id','I')");
       $resac = db_query("insert into db_acount values($acount,878,5652,'','".AddSlashes(pg_result($resaco,0,'tr11_id'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,878,5654,'','".AddSlashes(pg_result($resaco,0,'tr11_idveiculo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,878,5651,'','".AddSlashes(pg_result($resaco,0,'tr11_dtnasc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,878,5653,'','".AddSlashes(pg_result($resaco,0,'tr11_idhabilitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,878,5655,'','".AddSlashes(pg_result($resaco,0,'tr11_sexo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($tr11_id=null) { 
      $this->atualizacampos();
     $sql = " update condutores set ";
     $virgula = "";
     if(trim($this->tr11_id)!="" || isset($GLOBALS["HTTP_POST_VARS"]["tr11_id"])){ 
       $sql  .= $virgula." tr11_id = $this->tr11_id ";
       $virgula = ",";
       if(trim($this->tr11_id) == null ){ 
         $this->erro_sql = " Campo c�digo do condutor nao Informado.";
         $this->erro_campo = "tr11_id";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->tr11_idveiculo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["tr11_idveiculo"])){ 
       $sql  .= $virgula." tr11_idveiculo = $this->tr11_idveiculo ";
       $virgula = ",";
       if(trim($this->tr11_idveiculo) == null ){ 
         $this->erro_sql = " Campo Veiculo nao Informado.";
         $this->erro_campo = "tr11_idveiculo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->tr11_dtnasc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["tr11_dtnasc_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["tr11_dtnasc_dia"] !="") ){ 
       $sql  .= $virgula." tr11_dtnasc = '$this->tr11_dtnasc' ";
       $virgula = ",";
       if(trim($this->tr11_dtnasc) == null ){ 
         $this->erro_sql = " Campo Data de Nascimento nao Informado.";
         $this->erro_campo = "tr11_dtnasc_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["tr11_dtnasc_dia"])){ 
         $sql  .= $virgula." tr11_dtnasc = null ";
         $virgula = ",";
         if(trim($this->tr11_dtnasc) == null ){ 
           $this->erro_sql = " Campo Data de Nascimento nao Informado.";
           $this->erro_campo = "tr11_dtnasc_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->tr11_idhabilitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["tr11_idhabilitacao"])){ 
       $sql  .= $virgula." tr11_idhabilitacao = $this->tr11_idhabilitacao ";
       $virgula = ",";
       if(trim($this->tr11_idhabilitacao) == null ){ 
         $this->erro_sql = " Campo Tipo de Habiliti��o nao Informado.";
         $this->erro_campo = "tr11_idhabilitacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->tr11_sexo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["tr11_sexo"])){ 
       $sql  .= $virgula." tr11_sexo = '$this->tr11_sexo' ";
       $virgula = ",";
       if(trim($this->tr11_sexo) == null ){ 
         $this->erro_sql = " Campo Sexo nao Informado.";
         $this->erro_campo = "tr11_sexo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($tr11_id!=null){
       $sql .= " tr11_id = $this->tr11_id";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->tr11_id));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,5652,'$this->tr11_id','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["tr11_id"]))
           $resac = db_query("insert into db_acount values($acount,878,5652,'".AddSlashes(pg_result($resaco,$conresaco,'tr11_id'))."','$this->tr11_id',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["tr11_idveiculo"]))
           $resac = db_query("insert into db_acount values($acount,878,5654,'".AddSlashes(pg_result($resaco,$conresaco,'tr11_idveiculo'))."','$this->tr11_idveiculo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["tr11_dtnasc"]))
           $resac = db_query("insert into db_acount values($acount,878,5651,'".AddSlashes(pg_result($resaco,$conresaco,'tr11_dtnasc'))."','$this->tr11_dtnasc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["tr11_idhabilitacao"]))
           $resac = db_query("insert into db_acount values($acount,878,5653,'".AddSlashes(pg_result($resaco,$conresaco,'tr11_idhabilitacao'))."','$this->tr11_idhabilitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["tr11_sexo"]))
           $resac = db_query("insert into db_acount values($acount,878,5655,'".AddSlashes(pg_result($resaco,$conresaco,'tr11_sexo'))."','$this->tr11_sexo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Condutores dos veiculos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->tr11_id;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Condutores dos veiculos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->tr11_id;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->tr11_id;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($tr11_id=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($tr11_id));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,5652,'$tr11_id','E')");
         $resac = db_query("insert into db_acount values($acount,878,5652,'','".AddSlashes(pg_result($resaco,$iresaco,'tr11_id'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,878,5654,'','".AddSlashes(pg_result($resaco,$iresaco,'tr11_idveiculo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,878,5651,'','".AddSlashes(pg_result($resaco,$iresaco,'tr11_dtnasc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,878,5653,'','".AddSlashes(pg_result($resaco,$iresaco,'tr11_idhabilitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,878,5655,'','".AddSlashes(pg_result($resaco,$iresaco,'tr11_sexo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from condutores
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($tr11_id != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " tr11_id = $tr11_id ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Condutores dos veiculos nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$tr11_id;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Condutores dos veiculos nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$tr11_id;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$tr11_id;
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
        $this->erro_sql   = "Record Vazio na Tabela:condutores";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   function sql_query ( $tr11_id=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from condutores ";
     $sql .= "      inner join veiculos_env  on  veiculos_env.tr08_id = condutores.tr11_idveiculo";
     $sql .= "      inner join tipo_habilitacao  on  tipo_habilitacao.tr09_id = condutores.tr11_idhabilitacao";
     $sql .= "      inner join db_cepmunic  on  db_cepmunic.db10_codigo = veiculos_env.tr08_municipio";
     $sql .= "      inner join tipo_veiculos  on  tipo_veiculos.tr05_id = veiculos_env.tr08_idveiculo";
     $sql .= "      inner join acidentes  on  acidentes.tr07_id = veiculos_env.tr08_idacidente";
     $sql .= "      inner join tipo_habilitacao  as a on   a.tr09_id = veiculos_env.tr08_idhabilitacao";
     $sql2 = "";
     if($dbwhere==""){
       if($tr11_id!=null ){
         $sql2 .= " where condutores.tr11_id = $tr11_id "; 
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
   function sql_query_file ( $tr11_id=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from condutores ";
     $sql2 = "";
     if($dbwhere==""){
       if($tr11_id!=null ){
         $sql2 .= " where condutores.tr11_id = $tr11_id "; 
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