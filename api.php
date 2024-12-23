<?php

class API
{
    private $c; //variable que contiene la sesion cURL 
    private $apikey = 'moby_Ivjf8fphPEz3gLn9DVIcRsvNYgE'; // clave de la api que hay que añadir en cada consulta
    private $url = 'https://api.mobygames.com/v1/games'; //url de los juegos 

    public function __construct()
    {
        // Establecemos los parámetros cURL
        $this->c = curl_init();
        curl_setopt($this->c, CURLOPT_RETURNTRANSFER, true);
    }

    public function __destruct()
    {
        curl_close($this->c);
    }


    public function getIdJuego($titulo)
    {
        $juego = rawurlencode($titulo); //por ejemplo si buscas super mario bros: "Super%20Mario%20Bros%21"

        //todo lo siguiente es para hacer la solicitud en la api
        curl_setopt($this->c, CURLOPT_URL, $this->url . '?api_key=' . $this->apikey . '&format=id&title=' . $juego);
        $juego = curl_exec($this->c);
        sleep(5);

        // Decodificamos los datos porque están en JSON y los convertimos en array para devolverlos...
        $juego = json_decode($juego, true);
        return ($juego);
    }

    public function getDatosDeJuegoById($ids)
    {
        // Inicializar variable para almacenar los parámetros de la URL
        $idurl = '';

        // Asegurarnos de que $ids es un array no vacío
        if (empty($ids)) {
            return 'Error: No se proporcionaron IDs de juegos.';
        }

        // Construir la cadena de parámetros con los IDs de los juegos
        foreach ($ids as $id) {
            $idurl .= '&id=' . urlencode($id); // Usar urlencode para asegurar la correcta codificación de los IDs
        }

        // Configurar la URL de la solicitud cURL
        $url = $this->url . '?api_key=' . $this->apikey . $idurl;

        // Configurar la solicitud cURL
        curl_setopt($this->c, CURLOPT_URL, $url);
        curl_setopt($this->c, CURLOPT_RETURNTRANSFER, true); // Retornar la respuesta como una cadena

        // Ejecutar la solicitud cURL y capturar la respuesta
        $response = curl_exec($this->c);

        // Comprobar si ocurrió algún error durante la solicitud cURL
        if (curl_errno($this->c)) {
            // Si hay un error, devolverlo
            return 'Error de cURL: ' . curl_error($this->c);
        }

        // Comprobar si la respuesta es válida (no vacía)
        if (empty($response)) {
            return 'Error: La respuesta de la API está vacía.';
        }

        // Intentar decodificar la respuesta JSON
        $jsonResponse = json_decode($response, true);

        // Comprobar si la decodificación fue exitosa
        if (json_last_error() !== JSON_ERROR_NONE) {
            return 'Error: La respuesta no es un JSON válido.';
        }

        // Comprobar si la API ha retornado un error en la respuesta
        if (isset($jsonResponse['error'])) {
            return 'Error de API: ' . $jsonResponse['error'];
        }

        // Si todo está bien, devolver los datos obtenidos
        return $jsonResponse;
    }
    public function getInfoJuego($juego) {
		$ids = $this->getIdJuego($juego);
		$ids = $ids['games'];
		return($this->getDatosDeJuegoById($ids));
	}
}
