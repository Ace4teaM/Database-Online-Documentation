<?php
/*
    ---------------------------------------------------------------------------------------------------------------------------------------
    (C)2012-2013 Thomas AUGUEY <contact@aceteam.org>
    ---------------------------------------------------------------------------------------------------------------------------------------
    This file is part of WebFrameWork.

    WebFrameWork is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WebFrameWork is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WebFrameWork.  If not, see <http://www.gnu.org/licenses/>.
    ---------------------------------------------------------------------------------------------------------------------------------------
*/

/**
 *  Webframework Module
 *  PHP Data-Model Implementation
*/


/**
* @author       developpement
*/
class FunctionParameter
{
   public function getId(){
      return $this->functionParameterId;
  }
   public function setId($id){
      return $this->functionParameterId = $id;
  }

    
    /**
    * @var      int
    */
    public $functionParameterId;
    
    /**
    * @var      String
    */
    public $name;
    
    /**
    * @var      String
    */
    public $desc;
    
    /**
    * @var      String
    */
    public $dataType;    

}

/*
   function_parameter Class manager
   
   This class is optimized for use with the Webfrmework project (www.webframework.fr)
*/
class FunctionParameterMgr
{
    /**
     * @brief Convert existing instance to XML element
     * @param $inst Entity instance (FunctionParameter)
     * @param $doc Parent document
     * @return New element node
     */
    public static function toXML(&$inst,$doc) {
        $node = $doc->createElement(strtolower("FunctionParameter"));
        
        $node->appendChild($doc->createTextElement("function_parameter_id",$inst->functionParameterId));
        $node->appendChild($doc->createTextElement("name",$inst->name));
        $node->appendChild($doc->createTextElement("desc",$inst->desc));
        $node->appendChild($doc->createTextElement("data_type",$inst->dataType));       

          
        return $node;
    }
    
    
    /*
      @brief Get entry list
      @param $list Array to receive new instances
      @param $cond SQL Select condition
      @param $db iDataBase derived instance
    */
    public static function getAll(&$list,$cond,$db=null){
       $list = array();
      
       //obtient la base de donnees courrante
       global $app;
       if(!$db && !$app->getDB($db))
         return false;
      
      //execute la requete
       $query = "SELECT * from function_parameter where $cond";
       if(!$db->execute($query,$result))
          return false;
       
      //extrait les instances
       $i=0;
       while( $result->seek($i,iDatabaseQuery::Origin) ){
        $inst = new FunctionParameter();
        FunctionParameterMgr::bindResult($inst,$result);
        array_push($list,$inst);
        $i++;
       }
       
       return RESULT_OK();
    }
    
    /*
      @brief Get single entry
      @param $inst FunctionParameter instance pointer to initialize
      @param $cond SQL Select condition
      @param $db iDataBase derived instance
    */
    public static function bindResult(&$inst,$result){
          $inst->functionParameterId = $result->fetchValue("function_parameter_id");
          $inst->name = $result->fetchValue("name");
          $inst->desc = $result->fetchValue("desc");
          $inst->dataType = $result->fetchValue("data_type");          

       return true;
    }
    
    /*
      @brief Get single entry
      @param $inst FunctionParameter instance pointer to initialize
      @param $cond SQL Select condition
      @param $db iDataBase derived instance
    */
    public static function get(&$inst,$cond,$db=null){
       //obtient la base de donnees courrante
       global $app;
       if(!$db && !$app->getDB($db))
         return false;
      
      //execute la requete
       $query = "SELECT * from function_parameter where $cond";
       if($db->execute($query,$result)){
            $inst = new FunctionParameter();
             if(!$result->rowCount())
                 return RESULT(cResult::Failed,iDatabaseQuery::EmptyResult);
          return FunctionParameterMgr::bindResult($inst,$result);
       }
       return false;
    }
    
    /*
      @brief Get single entry by id
      @param $inst FunctionParameter instance pointer to initialize
      @param $id Primary unique identifier of entry to retreive
      @param $db iDataBase derived instance
    */
    public static function getById(&$inst,$id,$db=null){
       //obtient la base de donnees courrante
       global $app;
       if(!$db && !$app->getDB($db))
         return false;
      
      //execute la requete
       $query = "SELECT * from function_parameter where function_parameter_id=".$db->parseValue($id);
       if($db->execute($query,$result)){
            $inst = new FunctionParameter();
             if(!$result->rowCount())
                 return RESULT(cResult::Failed,iDatabaseQuery::EmptyResult);
             self::bindResult($inst,$result);
          return true;
       }
       return false;
    }
    
   /*
      @brief Insert single entry with generated id
      @param $inst WriterDocument instance pointer to initialize
      @param $add_fields Array of columns names/columns values of additional fields
      @param $db iDataBase derived instance
    */
    public static function insert(&$inst,$add_fields=null,$db=null){
       //obtient la base de donnees courrante
       global $app;
       if(!$db && !$app->getDB($db))
         return false;
      
       //id initialise ?
       if(!isset($inst->functionParameterId)){
            $table_name = 'function_parameter';
            $table_id_name = $table_name.'_id';
           if(!$db->execute("select * from new_id('$table_name','$table_id_name');",$result))
              return RESULT(cResult::Failed, cApplication::EntityMissingId);
           $inst->functionParameterId = intval($result->fetchValue("new_id"));
       }
       
      //execute la requete
       $query = "INSERT INTO function_parameter (";
       $query .= " function_parameter_id,";
       $query .= " name,";
       $query .= " desc,";
       $query .= " data_type,";
       if(is_array($add_fields))
           $query .= implode(',',array_keys($add_fields)).',';
       $query = substr($query,0,-1);//remove last ','
       $query .= ")";
       
       $query .= " VALUES(";
       $query .= $db->parseValue($inst->functionParameterId).",";
       $query .= $db->parseValue($inst->name).",";
       $query .= $db->parseValue($inst->desc).",";
       $query .= $db->parseValue($inst->dataType).",";
       if(is_array($add_fields))
           $query .= implode(',',$add_fields).',';
       $query = substr($query,0,-1);//remove last ','
       $query .= ")";
       
       if($db->execute($query,$result))
          return true;

       return false;
    }
    
   /*
      @brief Update single entry by id
      @param $inst WriterDocument instance pointer to initialize
      @param $db iDataBase derived instance
    */
    public static function update(&$inst,$db=null){
       //obtient la base de donnees courrante
       global $app;
       if(!$db && !$app->getDB($db))
         return false;
      
       //id initialise ?
       if(!isset($inst->functionParameterId))
           return RESULT(cResult::Failed, cApplication::EntityMissingId);
      
      //execute la requete
       $query = "UPDATE function_parameter SET";
       $query .= " function_parameter_id =".$db->parseValue($inst->functionParameterId).",";
       $query .= " name =".$db->parseValue($inst->name).",";
       $query .= " desc =".$db->parseValue($inst->desc).",";
       $query .= " data_type =".$db->parseValue($inst->dataType).",";
       $query = substr($query,0,-1);//remove last ','
       $query .= " where function_parameter_id=".$db->parseValue($inst->functionParameterId);
       if($db->execute($query,$result))
          return true;

       return false;
    }
    
   /** @brief Convert name to code */
    public static function nameToCode($name){
        for($i=strlen($name)-1;$i>=0;$i--){
            $c = substr($name, $i, 1);
            if(strpos("ABCDEFGHIJKLMNOPQRSTUVWXYZ",$c) !== FALSE){
                $name = substr_replace($name,($i?"_":"").strtolower($c), $i, 1);
            }
        }
        return $name;
    }
    
    /**
      @brief Get entry by id's relation table
      @param $inst FunctionParameter instance pointer to initialize
      @param $obj An another entry class object instance
      @param $db iDataBase derived instance
    */
    public static function getByRelation(&$inst,$obj,$db=null){
        $objectName = get_class($obj);
        $objectTableName  = FunctionParameterMgr::nameToCode($objectName);
        $objectIdName = lcfirst($objectName)."Id";
        
        /*print_r($objectName.", ");
        print_r($objectTableName.", ");
        print_r($objectIdName.", ");
        print_r($obj->$objectIdName);*/
        
        $select;
        if(is_string($obj->$objectIdName))
            $select = ("function_parameter_id = (select function_parameter_id from $objectTableName where ".$objectTableName."_id='".$obj->$objectIdName."')");
        else
            $select = ("function_parameter_id = (select function_parameter_id  from $objectTableName where ".$objectTableName."_id=".$obj->$objectIdName.")");

        return FunctionParameterMgr::get($inst,$select,$db);
    }

}

?>