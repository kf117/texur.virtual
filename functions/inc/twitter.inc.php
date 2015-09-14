    <?php
  
      /*
  36.
       
  37.
      @author: Fabian Ramirez Sepulveda
  38.
      @email : framirez(ARROB)gurunet.cl
  39.
      @web : http://www.gurunet.cl/framirez
  40.
       
  41.
      @desc: Proyecto para tener una API desde PHP mas accesible y facil para usuarios no avanzados.
  42.
       
  43.
      @metodos:
  44.
      lineaTiempo( $nickNameAmigo=opcional) - "Nos retorna todos los ultimos 10 mensajes que nuestro amigo o nosotros hemos posteado"
  45.
      tomarMensaje($idmensaje) - "Nos retorna el detalle completo del mensaje"
  46.
      postearMensaje($mensaje) - "Posteamos en tiempo real el mensaje desde PHP"
  47.
      seguidores() - "Nos retorna todos nuestros amigos que nos siguen"
  48.
      */
  
       
  
      // Libreria necesaria para procesar Xpath
  
      require_once('XPath.class.php');
  
       
  
      class Twitter {
  
       
  
      var $usuario='';
  
      var $password='';
  
       
  
      // Headers de nuestro cliente
  
      var $agente = 'Twitter PHP Class by framirez';
  
      var $headers = array('X-Twitter-Client: Twitter PHP by framirez',
  
      'X-Twitter-Client-Version: 1.0',
  
      'X-Twitter-Client-URL: http://www.gurunet.cl/framirez');
  
       
 
      // Curl
  
      var $ch;
  
       
  
      // Respuesta
  
      var $respuesta;
  
       
  
      var $xml;
  
       
  
      function Twitter($usuario=null, $password=null) {
  
      $this->usuario = $usuario;
  
      $this->password = $password;
  
       
  
  
 
      // Metodo constructor automaticamente llama a Xpath
  
      $this->xml = new XPath();
  
      }
  
      /*
  80.
      @desc: Retornamos el maximo de 10 mensajes de amigos o mios
  81.
      */
 
      function lineaTiempo($nick = null) {
  
       
  
      if(empty($nick)):
  
      $this->ch = curl_init("http://twitter.com/statuses/user_timeline.xml");
  
      $this->xml->importFromString($this->setearOpcionesCurl());
  
      else:

      $this->ch = curl_init("http://twitter.com/statuses/user_timeline/" . $nick . ".xml");
  
      $this->xml->importFromString($this->setearOpcionesCurl());
      // die(print_r( $this->ch));
      endif;
  
       
  
      // Xpath Match
  
      $id = $this->xml->match('//id');
  
      $nickname = $this->xml->match('//screen_name');
  
      $texto = $this->xml->match('//text');
  
      $hora = $this->xml->match('//created_at');
  
      $desde = $this->xml->match('//location');
  
      $deDonde = $this->xml->match('//source');
  
       
 
      // Variables Temporales
 
      $i=0;
 
      $arregloMensajes = array();
 
       

      // Recorro el arreglo
 
      for($i=0;$i<count($texto);$i++):

      $arregloMensajes[$i]['id'] = $this->xml->getData($id[$i]);
 
      $arregloMensajes[$i]['usuario'] = $this->xml->getData($nickname[$i]);
 
      $arregloMensajes[$i]['mensaje'] = $this->xml->getData($texto[$i]);
 
      $arregloMensajes[$i]['hora'] = $this->xml->getData($hora[$i]);
 
      $arregloMensajes[$i]['desde'] = $this->xml->getData($desde[$i]);

      $arregloMensajes[$i]['donde_proviene'] = $this->xml->getData($deDonde[$i]);
 
      
 
      endfor;
 
       
 
      $this->xml->reset();
 
      return $arregloMensajes;
 
      }
 
       
 
      function tomarMensaje($id) {
 
      $this->ch = curl_init("http://twitter.com/statuses/user_timeline.xml");
 
      $this->xml->importFromString($this->setearOpcionesCurl());
 
       
 
      // Xpath Match
 
      $id = $this->xml->match('//id');

      $nickname = $this->xml->match('//screen_name');
 
      $texto = $this->xml->match('//text');

      $hora = $this->xml->match('//created_at');
 
      $desde = $this->xml->match('//location');
 
      $deDonde = $this->xml->match('//source');
 
       
 
      // Variables Temporales
 
      $arregloMensajes = array();
 
       
 
      // Recorro el arreglo
 
      $arregloMensajes['id'] = $this->xml->getData($id[0]);
 
      $arregloMensajes['usuario'] = $this->xml->getData($nickname[0]);
 
      $arregloMensajes['mensaje'] = $this->xml->getData($texto[0]);
 
      $arregloMensajes['hora'] = $this->xml->getData($hora[0]);
 
      $arregloMensajes['desde'] = $this->xml->getData($desde[0]);
 
      $arregloMensajes['donde_proviene'] = $this->xml->getData($deDonde[0]);
 
       
 
      $this->xml->reset();
 
      return $arregloMensajes;
 
      }
 
       
 
      function postearMensaje($mensaje) {
 
       
 
      if(empty($mensaje)):
 
      die("Debes pasar como parametro el mensaje");
 
      else:

      $this->ch = curl_init("http://twitter.com/statuses/update.xml");
 
      $this->xml->importFromString($this->setearOpcionesCurl('status=' . urlencode($mensaje)));
 
      $this->xml->reset();
 
      endif;
 
       
 
      return true;

      }
 
       
 
      function seguidores() {

      $this->ch = curl_init("http://twitter.com/statuses/followers.xml");
 
      $this->xml->importFromString($this->setearOpcionesCurl());
 
      // Xpath Match
 
      $id = $this->xml->match('//id');
 
      $nickname = $this->xml->match('//screen_name');
 
      $nombre = $this->xml->match('//name');
 
      $desde = $this->xml->match('//location');
 
      $web = $this->xml->match('//url');
 
      $foto = $this->xml->match('//profile_image_url');
 
      $descripcion = $this->xml->match('//description');
 
      // Variables Temporales
 
      $i=0;
 
      $arregloMensajes = array();
 
      // Recorro el arreglo

      for($i=0;$i<count($nickname);$i++):
 
      $arregloMensajes[$i]['id'] = $this->xml->getData($id[$i]);
 
      $arregloMensajes[$i]['nombre'] = $this->xml->getData($nombre[$i]);

      $arregloMensajes[$i]['desde'] = $this->xml->getData($desde[$i]);

      $arregloMensajes[$i]['usuario'] = $this->xml->getData($nickname[$i]);

      $arregloMensajes[$i]['web'] = $this->xml->getData($web[$i]);

      $arregloMensajes[$i]['foto'] = $this->xml->getData($foto[$i]);
 
      $arregloMensajes[$i]['descripcion'] = $this->xml->getData($descripcion[$i]);
 
      $i++;

      endfor;

      $this->xml->reset();

      return $arregloMensajes;

      }

      function setearOpcionesCurl($post=false) {

      // Autentificamos

      curl_setopt($this->ch, CURLOPT_USERPWD, $this->usuario.':'.$this->password);

      if(!empty($post)){
 
      curl_setopt($this->ch, CURLOPT_POST, true);

      curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post);

      }

      curl_setopt($this->ch, CURLOPT_VERBOSE, 1);

      curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);

      curl_setopt($this->ch, CURLOPT_USERAGENT, $this->agente);

      // Setamos la respuesta

      $respuesta = curl_exec($this->ch);

      curl_close($this->ch);

      unset($this->ch);

       

      return $respuesta;

      }
 
       

      }
      
      
?>