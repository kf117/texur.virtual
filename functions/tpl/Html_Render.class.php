<?php
/**
 * Extension a Sigma
 * Paquete		lib
 * Fecha		30-mar-2006
 * Proyecto		Head
 * @author		Saul Manattini <smanattini@rcnet.com.ar>
 * @access		public
 * @version		1.5
 * 
 * metodos:
 * 
 * Html_Render($root = '', $cacheRoot = '')
 * constructor
 * 
 * loadTemplateFile($filename, $removeUnknownVariables = true, $removeEmptyBlocks = true) 
 * metodo "sobrecargado", setea el nombre de la plantilla en uso, usado por si se habilita el uso de cache "full"     
 *  
 * setFullCacheRoot($root)
 * setea el path para la cache "full"
 * 
 * showCached()
 * imprime el template en la cache
 * 
 * getCached()
 * retorna el contenido del template en la cache
 * 
 * isCached()
 * verifica si el template tiene una cache full y si esta dentro de los parametros de duracion
 * 
 * Funciones de plantilla:
 *
 * now()
 * retorna la fecha actual 
 * 
 * strong()
 * añade la etiqueta <strong></strong> a la variable
 *
 */

if(!class_exists("HTML_Template_Sigma")) {
    require_once((dirname(__FILE__)) . '/Sigma.php');
}

define('SIGMAX_FULL_CACHE_ERROR',-15);
define('SIGMAX_TPL_CACHE_NOT_FOUND',-16);
define('SIGMAX_CONF_FILE_NOT_FOUND',-17);

class Html_Render extends HTML_Template_Sigma {

   /**
    * Nombre del template actualmente usado, sirve para el caso de cache "full"
    * @var      string
    * @access   private
    */
    var $_templateFileName = null;

   /**
    * Directorio para guardar la cache "full"
    * el setear esta variable hace que el uso de la cache este activado
    * @var      string
    * @access   private
    */
    var $_fullCacheRoot = null;

    /**
     * Tiempo de tolerancia antes de refrescar la cache
     *
     * @var      string
     * @access   private
     */
    var $_fullCachedTime = '10 seconds';

   /**
    * RegExp usada para incluir archivos de configuracion
    * @var  string
    */
    var $includeConfRegExp = '#<!--\s+INCLUDE_CONF\s+(\S+)\s+-->#ime';

    /**
     * lista de funciones de template que son funciones de php
     * @access private
     */
    var $_callPhpFunc = array('mayus'    => 'strtoupper',
                              'minus'    => 'strtolower',
                              'capital'  => 'ucfirst',
                              'titular'  => 'ucwords');

    /**
     * cantidad actual de variables seteadas
     * @access private
     */
    var $_variablesCount = 0;

    /**
     * cantidad en la cual se toma en cuenta que la lista de variables seteadas es grande
     * @access private
     */
    var $_variablesBig = 100;

    function Html_Render($root = '', $cacheRoot = '') {

        parent::HTML_Template_Sigma($root, $cacheRoot);

        /* funciones añadidas*/
        $this->setCallbackFunction('negrita', array(&$this, 'negrita'));
        foreach($this->_callPhpFunc as $lF => $phpF)
            $this->setCallbackFunction($lF, $phpF);

        $this->setCallbackFunction('apply', array(&$this, 'apply'));
        $this->setCallbackFunction('limit', array(&$this, 'limit'));
        /* falta italica = italica*/
    }
   
   /**
    * "Proxy" del metodo en sigma, solo agrega el nombre del actualmente procesado
    * por el tema de usar cache "full"
    * @see      HTML_Template_Sigma::loadTemplateFile()
    */
    function loadTemplateFile($filename, $removeUnknownVariables = true, $removeEmptyBlocks = true) {
        $this->_templateFileName = $filename;
        return parent::loadTemplateFile($filename, $removeUnknownVariables, $removeEmptyBlocks);
    }


   /**
    * sobrecarga del metodo de HTML_Template_Sigma, porque en el metodo base si se pasa un array
    * se hace un merge con la lista de variables ya existentes, pero un foreach es mas rapido
    * si el array es grande
    * 
    * @access public
    * @see      definicion en HTML_Template_Sigma
    */
    function setVariable($variable, $value = '') {
        
        if (is_array($variable)) {
            if($this->_variablesCount > $this->_variablesBig) {
                foreach($variable as $tplVar => $tplVarVal) {
                    $this->_variables[$tplVar] = $tplVarVal;
                    $this->_variablesCount++;
                }
            }
            else {
                $this->_variables = array_merge($this->_variables, $variable); 
                $this->_variablesCount += count($variable);   
            }
        } else {
            $this->_variables[$variable] = $value;
            $this->_variablesCount++;
        }
    }

   /**
    * @see    Sigma::clearVariables()
    */
    function clearVariables() {
        $this->_variablesCount = 0;
        $this->_variables = array();
    }
    
   /**
    * @see    Sigma::clearVariables()
    * @access private
    */
    function _resetTemplate($removeUnknownVariables = true, $removeEmptyBlocks = true) {
        $this->_variablesCount = 0;
        parent::_resetTemplate($removeUnknownVariables, $removeEmptyBlocks);
    } /* _resetTemplate*/
    
    /**
     * Setea el directorio donde se aloja|busca la cache "full"
     * al hacerlo, la opcion de cache full es activada
     * 
     * @access       public
     */
    function setFullCacheRoot($root) {
        if (empty($root)) {
            return true;
        } elseif (('' != $root) && ('/' != substr($root, -1))) {
            $root .= '/';
        }
        $this->_fullCacheRoot = $root;
    }

    /**
     * Setea el nombre para ser tomado como de cache "full"
     * si no se setea el nombre es es del template original
     * 
     * @access       public
     */
    function setCachedName($name) {
        $this->_templateFileName = $name;
    }
    
    /**
     * Visualiza el archivo de cache full
     * 
     * @access       public
     */
    function showCached() {
        print $this->getCached();   
    }      

    /**
     * Retorna todo el contenido de la cache
     * 
     * @access       public
     */
    function getCached() {
        if($this->isCached())
            return file_get_contents($this->_fullCachedName($this->_templateFileName));
        else {
            return $this->raiseError($this->errorMessage(SIGMAX_TPL_CACHE_NOT_FOUND, $this->_templateFileName), SIGMAX_TPL_CACHE_NOT_FOUND);
        }       
    }      
    
    /**
     * "Sobrecarga" del metodo base por el uso de la cache
     * 
     * @access       public
     */
    function get($block = '__global__', $clear = false) {
        
        if ( ($block == '__global__') && (null !== $this->_fullCacheRoot) ) {
                    
            if(!$this->isCached())
                $this->_writeFullCache($this->_templateFileName);

            return file_get_contents($this->_fullCachedName($this->_templateFileName));            
        }
        else
            return parent::get($block,$clear);
                   
    }      

    /**
     * Verifica si el template en uso tiene una cache "full"
     * @access       public
     * @return       bool  
     */
    function isCached() {
        return $this->_isFullCached($this->_templateFileName);
    } 
    
    /**
     * Añade el tag strong al valor
     * 
     * @access       public
     * @example      {valor:sg}
     * @return       string 
     */
/*    function negrita($value) {
        return '<b>' . $this->_cleanVar($value) . '</b>';
    }*/
    function negrita($value) {
        return '<b>' . $value . '</b>';
    }
    
    
    /**
     * Aplica mas de un filtro a una variable
     * 
     * @access       public
     * @example      func_apply('{var}','negrita','capital');
     * @return       string 
     */
    function apply() {
        $params = func_get_args();
        $cad = array_shift($params);
        foreach($params as $func) {
            if(array_key_exists($func,$this->_callPhpFunc)) {
                $cad = $this->_callPhpFunc[$func]($cad);
            }else
                $cad = $this->$func($cad);        
        } 
        return $cad;
    }

    /**
     * Limita la cantidad de caracteres de una cadena a la longitud deseada, si la corta agrega ... al final
     * por defecto es 255
     * @access       public
     * @example      func_limit('{var}',longitud);
     * @return       string
     */
    function limit($cad, $to = 255) {
        if(strlen($cad) > $to)
            $cad = substr($cad, 0, $to) . "...";
        return $cad;
    }

    /*-------------------------------------------------
    //          METODOS PRIVADOS
    //-------------------------------------------------*/

    /**
     * Retorna el nombre completo del archivo cacheado completamente (no es igual a informacion cacheada)
     * 
     * @access private
     * @param string  nombre del archivo origen, relativo al directorio raiz
     * @return string nombre de archivo
     */
    function _fullCachedName($filename) {
        /*escapar caracteres de url (si los hay)*/
        $filename = eregi_replace("[\?|=|&]","_",$filename);
        
        if(OS_UNIX == true) {
            if ('/' == $filename{0} && '/' == substr($this->_fullCacheRoot, -1)) {
                $filename = substr($filename, 1);
            }
            $filename = str_replace('/', '__', $filename);
        }
        else {
            /*agregado compatibilidad win*/
            if ('\\' == $filename{0} && '\\' == substr($this->_fullCacheRoot, -1)) {
                $filename = substr($filename, 1);
            }
            $filename = str_replace('/', '__', $filename);            
            $filename = str_replace(':', '__', $filename);
            $filename = str_replace('\\', '__', $filename);            
        }
/*        if ('/' == $filename{0} && '/' == substr($this->_cacheRoot, -1)) {
            $filename = substr($filename, 1);
        }
        $filename = str_replace('/', '__', $filename);*/
        return $this->_fullCacheRoot. $filename. '.it';
    } /* _fullCachedName*/
    
    /**
     * Checkea si hay una cache "full" del template
     * 
     * Si no esta habilitada la opcion de cacheo full, siempre retorna false
     * 
     * @access private
     * @param  string nombre del archivo
     * @return bool yes/no
     */
    function _isFullCached($filename) {
        
        if (null === $this->_fullCacheRoot) {
            return false;
        }
        
        $cachedName = $this->_fullCachedName($filename);

        if (@is_file($cachedName) && (date("Y m d H:i:s",filemtime($cachedName)) >= date("Y m d H:i:s",strtotime("-" . $this->_fullCachedTime)))) 
            return true;
        else 
            return false;

    } /* _isFullCached*/
    
    
    /**
     * Guarda la cache full
     * 
     * @access private
     * @param string   source filename, relative to root directory
     * @param string   name of the block to save into file
     * @return mixed   SIGMA_OK on success, error object on failure
     */
    function _writeFullCache($filename) {
        /* no guarda nada si no esta seteado el directorio de cache full*/
        if (null !== $this->_fullCacheRoot) {
            $cachedName = $this->_fullCachedName($filename);

            if (!($fh = @fopen($cachedName, 'w'))) {
                return $this->raiseError($this->errorMessage(SIGMAX_FULL_CACHE_ERROR, $cachedName), SIGMAX_FULL_CACHE_ERROR);
            }
            fwrite($fh,parent::get());
            fclose($fh);
        }

        return SIGMA_OK;
    } 
    
    /**
     * Sobrecarga del metodo base
     * @access private
     * @see parent::errorMessage($code, $data = null)  
     */
    function errorMessage($code, $data = null) {

        static $errorMessages;

        if (!isset($errorMessages)) {
            $errorMessages = array(
                SIGMAX_FULL_CACHE_ERROR    => 'No se puede escribir el archivo de cache full del template \'%s\'',
                SIGMAX_TPL_CACHE_NOT_FOUND => 'No se puede leer el archivo de cache del template \'%s\'',
                SIGMAX_CONF_FILE_NOT_FOUND => 'No se puede leer el archivo de configuracion \'%s\''
            );
        }

        if (!isset($errorMessages[$code])) {
            return parent::errorMessage($code,$data);
        } else {
            return (null === $data)? $errorMessages[$code]: sprintf($errorMessages[$code], $data);
        }
    }
    
}/*Html_Render*/
?>
