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

//MODULO: cadastro
//CLASSE DA ENTIDADE iptucalcpadrao
class cl_iptucalcpadrao { 
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
   var $j10_sequencial = 0; 
   var $j10_anousu = 0; 
   var $j10_matric = 0; 
   var $j10_vlrter = 0; 
   var $j10_aliq = 0; 
   var $j10_perccorre = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 j10_sequencial = int8 = C�digo 
                 j10_anousu = int4 = Anousu 
                 j10_matric = int8 = Matr�cula 
                 j10_vlrter = float8 = Valor 
                 j10_aliq = float8 = Aliquota 
                 j10_perccorre = float8 = Percentual de corre��o 
                 ";
   //funcao construtor da classe 
   function cl_iptucalcpadrao() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("iptucalcpadrao"); 
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
       $this->j10_sequencial = ($this->j10_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["j10_sequencial"]:$this->j10_sequencial);
       $this->j10_anousu = ($this->j10_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["j10_anousu"]:$this->j10_anousu);
       $this->j10_matric = ($this->j10_matric == ""?@$GLOBALS["HTTP_POST_VARS"]["j10_matric"]:$this->j10_matric);
       $this->j10_vlrter = ($this->j10_vlrter == ""?@$GLOBALS["HTTP_POST_VARS"]["j10_vlrter"]:$this->j10_vlrter);
       $this->j10_aliq = ($this->j10_aliq == ""?@$GLOBALS["HTTP_POST_VARS"]["j10_aliq"]:$this->j10_aliq);
       $this->j10_perccorre = ($this->j10_perccorre == ""?@$GLOBALS["HTTP_POST_VARS"]["j10_perccorre"]:$this->j10_perccorre);
     }else{
       $this->j10_sequencial = ($this->j10_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["j10_sequencial"]:$this->j10_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($j10_sequencial){ 
      $this->atualizacampos();
     if($this->j10_anousu == null ){ 
       $this->erro_sql = " Campo Anousu nao Informado.";
       $this->erro_campo = "j10_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j10_matric == null ){ 
       $this->erro_sql = " Campo Matr�cula nao Informado.";
       $this->erro_campo = "j10_matric";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j10_vlrter == null ){ 
       $this->erro_sql = " Campo Valor nao Informado.";
       $this->erro_campo = "j10_vlrter";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j10_aliq == null ){ 
       $this->erro_sql = " Campo Aliquota nao Informado.";
       $this->erro_campo = "j10_aliq";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j10_perccorre == null ){ 
       $this->erro_sql = " Campo Percentual de corre��o nao Informado.";
       $this->erro_campo = "j10_perccorre";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($j10_sequencial == "" || $j10_sequencial == null ){
       $result = db_query("select nextval('iptucalcpadrao_j10_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: iptucalcpadrao_j10_sequencial_seq do campo: j10_sequencial"; 
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->j10_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from iptucalcpadrao_j10_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $j10_sequencial)){
         $this->erro_sql = " Campo j10_sequencial maior que �ltimo n�mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n�mero.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->j10_sequencial = $j10_sequencial; 
       }
     }
     if(($this->j10_sequencial == null) || ($this->j10_sequencial == "") ){ 
       $this->erro_sql = " Campo j10_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into iptucalcpadrao(
                                       j10_sequencial 
                                      ,j10_anousu 
                                      ,j10_matric 
                                      ,j10_vlrter 
                                      ,j10_aliq 
                                      ,j10_perccorre 
                       )
                values (
                                $this->j10_sequencial 
                               ,$this->j10_anousu 
                               ,$this->j10_matric 
                               ,$this->j10_vlrter 
                               ,$this->j10_aliq 
                               ,$this->j10_perccorre 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Calculo padr�o ($this->j10_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Calculo padr�o j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Calculo padr�o ($this->j10_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j10_sequencial;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->j10_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,11009,'$this->j10_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,1897,11009,'','".AddSlashes(pg_result($resaco,0,'j10_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1897,9499,'','".AddSlashes(pg_result($resaco,0,'j10_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1897,11011,'','".AddSlashes(pg_result($resaco,0,'j10_matric'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1897,11012,'','".AddSlashes(pg_result($resaco,0,'j10_vlrter'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1897,11013,'','".AddSlashes(pg_result($resaco,0,'j10_aliq'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1897,11058,'','".AddSlashes(pg_result($resaco,0,'j10_perccorre'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($j10_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update iptucalcpadrao set ";
     $virgula = "";
     if(trim($this->j10_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["j10_sequencial"])){ 
       $sql  .= $virgula." j10_sequencial = $this->j10_sequencial ";
       $virgula = ",";
       if(trim($this->j10_sequencial) == null ){ 
         $this->erro_sql = " Campo C�digo nao Informado.";
         $this->erro_campo = "j10_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->j10_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["j10_anousu"])){ 
       $sql  .= $virgula." j10_anousu = $this->j10_anousu ";
       $virgula = ",";
       if(trim($this->j10_anousu) == null ){ 
         $this->erro_sql = " Campo Anousu nao Informado.";
         $this->erro_campo = "j10_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->j10_matric)!="" || isset($GLOBALS["HTTP_POST_VARS"]["j10_matric"])){ 
       $sql  .= $virgula." j10_matric = $this->j10_matric ";
       $virgula = ",";
       if(trim($this->j10_matric) == null ){ 
         $this->erro_sql = " Campo Matr�cula nao Informado.";
         $this->erro_campo = "j10_matric";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->j10_vlrter)!="" || isset($GLOBALS["HTTP_POST_VARS"]["j10_vlrter"])){ 
       $sql  .= $virgula." j10_vlrter = $this->j10_vlrter ";
       $virgula = ",";
       if(trim($this->j10_vlrter) == null ){ 
         $this->erro_sql = " Campo Valor nao Informado.";
         $this->erro_campo = "j10_vlrter";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->j10_aliq)!="" || isset($GLOBALS["HTTP_POST_VARS"]["j10_aliq"])){ 
       $sql  .= $virgula." j10_aliq = $this->j10_aliq ";
       $virgula = ",";
       if(trim($this->j10_aliq) == null ){ 
         $this->erro_sql = " Campo Aliquota nao Informado.";
         $this->erro_campo = "j10_aliq";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->j10_perccorre)!="" || isset($GLOBALS["HTTP_POST_VARS"]["j10_perccorre"])){ 
       $sql  .= $virgula." j10_perccorre = $this->j10_perccorre ";
       $virgula = ",";
       if(trim($this->j10_perccorre) == null ){ 
         $this->erro_sql = " Campo Percentual de corre��o nao Informado.";
         $this->erro_campo = "j10_perccorre";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($j10_sequencial!=null){
       $sql .= " j10_sequencial = $this->j10_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->j10_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,11009,'$this->j10_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["j10_sequencial"]))
           $resac = db_query("insert into db_acount values($acount,1897,11009,'".AddSlashes(pg_result($resaco,$conresaco,'j10_sequencial'))."','$this->j10_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["j10_anousu"]))
           $resac = db_query("insert into db_acount values($acount,1897,9499,'".AddSlashes(pg_result($resaco,$conresaco,'j10_anousu'))."','$this->j10_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["j10_matric"]))
           $resac = db_query("insert into db_acount values($acount,1897,11011,'".AddSlashes(pg_result($resaco,$conresaco,'j10_matric'))."','$this->j10_matric',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["j10_vlrter"]))
           $resac = db_query("insert into db_acount values($acount,1897,11012,'".AddSlashes(pg_result($resaco,$conresaco,'j10_vlrter'))."','$this->j10_vlrter',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["j10_aliq"]))
           $resac = db_query("insert into db_acount values($acount,1897,11013,'".AddSlashes(pg_result($resaco,$conresaco,'j10_aliq'))."','$this->j10_aliq',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["j10_perccorre"]))
           $resac = db_query("insert into db_acount values($acount,1897,11058,'".AddSlashes(pg_result($resaco,$conresaco,'j10_perccorre'))."','$this->j10_perccorre',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Calculo padr�o nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->j10_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Calculo padr�o nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->j10_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j10_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($j10_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($j10_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,11009,'$j10_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,1897,11009,'','".AddSlashes(pg_result($resaco,$iresaco,'j10_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1897,9499,'','".AddSlashes(pg_result($resaco,$iresaco,'j10_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1897,11011,'','".AddSlashes(pg_result($resaco,$iresaco,'j10_matric'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1897,11012,'','".AddSlashes(pg_result($resaco,$iresaco,'j10_vlrter'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1897,11013,'','".AddSlashes(pg_result($resaco,$iresaco,'j10_aliq'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1897,11058,'','".AddSlashes(pg_result($resaco,$iresaco,'j10_perccorre'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from iptucalcpadrao
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($j10_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " j10_sequencial = $j10_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Calculo padr�o nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$j10_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Calculo padr�o nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$j10_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$j10_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:iptucalcpadrao";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   function sql_query ( $j10_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from iptucalcpadrao ";
     $sql .= "      inner join iptubase  on  iptubase.j01_matric = iptucalcpadrao.j10_matric";
     $sql .= "      inner join lote  on  lote.j34_idbql = iptubase.j01_idbql";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = iptubase.j01_numcgm";
     $sql2 = "";
     if($dbwhere==""){
       if($j10_sequencial!=null ){
         $sql2 .= " where iptucalcpadrao.j10_sequencial = $j10_sequencial "; 
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
   function sql_query_file ( $j10_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from iptucalcpadrao ";
     $sql2 = "";
     if($dbwhere==""){
       if($j10_sequencial!=null ){
         $sql2 .= " where iptucalcpadrao.j10_sequencial = $j10_sequencial "; 
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