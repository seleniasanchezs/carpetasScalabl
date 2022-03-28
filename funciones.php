<?php
	session_start();

	require_once('../inc/header.php');
	require_once('../inc/footer.php');
    require_once("../inc/mails/mail_helper.class.php");


	if ( isset($_POST["guardar_registro"]) ) guardar_registro($_POST);
	if ( isset($_POST["cmdLogin"]) ) login($_POST);

    # login
    function login($post) {
        extract($post);
        require($_SERVER["DOCUMENT_ROOT"] . "/inc/configuracion.inc");

        $sql = "SELECT * FROM admin WHERE usuario = '$tbUsuario' AND password = '$tbPassword'";
        $res = mysqli_query($connection, $sql);

        if (mysqli_num_rows($res) > 0) {
            $u = array();
            $reg = mysqli_fetch_array($res);
            extract($reg);
            $u = array(
                "nombre" => "scalabl"
            );
            $_SESSION["scalabl_admin_root_user"] = $u;
            header("Location: registros.php?logOk");
        } else {
            header("Location: login.php?userError");
        }
    }

	# guardar registro
	function guardar_registro($post) {
		extract($post);
        require('../inc/configuracion.inc');

		$fecha_registro = date("Y-m-d H:i:s");
		$nombre = utf8_decode($nombre);
		$apellido = utf8_decode($apellido);
        $insert = "INSERT INTO ucema_registros VALUES (null, '$nombre', '$apellido', '$email', '$fecha_elegida', '$fecha_registro')";

        if (mysqli_query($connection, $insert) or die(mysqli_error($connection))) {
			echo 1;
			enviar_mail($nombre, $apellido, $email, $fecha_elegida, $fecha_registro);
        } else {
			echo 0;
        }
	}

	# enviar mail con los datos del registro guardado
    function enviar_mail($nombre, $apellido, $email, $fecha_elegida, $fecha_registro)
    {
        $mail = new Mail;

        $destinatarios = array("francisco@scalable.business", "paula@scalable.business", "info@scalabl.com");

        $mail->set_from_email("sender@scalabl.com"); // cuenta a la que se reponde el mail
        $mail->set_from_name("Scalabl | MBA UCEMA"); // nombre del que envía
        $mail->set_destinatarios($destinatarios); // array de destinatarios

        $mail_html = "
            <h2>MBA UCEMA | Nuevo registro</h2>
            <p>Nombre: $nombre $apellido</p>
            <p>Email: $email</p>
            <p>Fecha elegida: $fecha_elegida</p>
            <p>Fecha de nacimiento: $fecha_registro</p>
            ";

        $mail->set_asunto("Scalabl | MBA UCEMA Nuevo registro"); // asunto
        $mail->set_body_html($mail_html); // body html
        $mail->set_body($mail_html); // body sin html
        $mail->send_email();
    }

    function get_registros() {
        require('../inc/configuracion.inc');

        $sql = "SELECT * FROM ucema_registros ORDER BY fecha_registro DESC";
        $res = mysqli_query($connection, $sql);

        if (mysqli_num_rows($res) == 0) return 0;

        $v = array();
        while ($f = mysqli_fetch_array($res)) {
            extract($f);

            $v[] = array(
                "id"                => $id,
                "nombre"            => utf8_encode($nombre),
                "apellido"          => utf8_encode($apellido),
                "email"             => $email,
                "fecha_curso"       => $fecha_elegida,
                "fecha_registro"    => date_format(new DateTime($fecha_registro), "d/m/Y H:i:s")
            );
        }
        return $v;
    }
?>