<?php 

/**
* 
*/
class Admin extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			
			$this->_modulo_id = "PERFIL DEL ADMIN";
			$this->_plantilla = "admin/template/head";//el nav y head

			///$this->_plant = "template/admin_lte.php";//el nav y head			
			$this->load->database();
			$this->load->helper('url');

			$this->load->library('grocery_CRUD');
			$this->load->model('grocery_crud_model');
			
			$this->load->library('email');
			$this->load->library('upload');
			$this->load->library('form_validation');
			$this->load->library('tooltip_gcrud');  //load the library

			
		}


		public function _example_output($output = null,$salida=null)
	{	

		 if (!$this->session->userdata('login')) 
        	{
        			redirect(base_url('http://glologistics.com.mx/login.html'));
        	}

        	else{

        			if ($this->session->userdata('nivel')=="admin"){
        			if (isset($salida)) {
					
					$data['jq']='<script src="<?php echo base_url("plantilla/vendor/") ?>/jquery/jquery.min.js"></script>';
					$data['pagina_interna']=$salida;
					 $data['app']="Home";
					 $data['name']="GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0";
					
					 $data['title']="Mis Horarios";
					 
					
					$this->load->view($this->_plantilla, (array)$salida);
					}
					else{

					 $data['app']="Home";
					 $data['name']="GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0";
					
					 $data['title']="Mis Horarios";
					 
					$this->load->view($this->_plantilla,$output);
				$this->load->view('admin/web/provedores',$salida);
					}

				}
				
					else{
		        	$this->session->sess_destroy();//para destruir sesion
					redirect(base_url('http://glologistics.com.mx/login.html'));
        		 }


        	}			
						
	}

		 function index()
		{
		 $this->load->library('session');

				$pagina="admin/web/inicial";
				$app="Home";
				$name="GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0";
				$title="Mis Horarios";			
			
		 		$this->_example_output((object)array('name'=>$name,'title'=>$title,'pagina_interna'=>$pagina,'output' => '', 'js_files' =>array(), 'css_files' => array(), 'app' => $app,'name'=>$name,$title=>'GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0'),(object)array('pagina_interna'=>$pagina,'title'=>$title,'output' => '', 'js_files' =>array(), 'css_files' => array(), 'app' => $app,'name'=>$name,$title=>'GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0')  );
				

	
		}



	    function Provedores()
		{
				 $this->load->library('session');

				 	try{
						
						$this->db = $this->load->database("default", TRUE);
						
						$crud = new grocery_CRUD();
						
						$crud->set_theme('bootstrap');
						$crud->set_table('provedores');
						$crud->set_primary_key('id'); // Indicar el campo Llave
						$crud->set_subject('Provedores del Sistema');
						//$crud->required_fields('Provedores del Sistema');
						
						
						$crud->columns('Nombre','Apellidos','Direccion','Correo'); 
						$crud->display_as('Nombre','Nombre del provedor');
						$crud->display_as('Apellidos','Apellidos del provedor');
						$crud->display_as('Direccion','Direccion del provedor');
						$crud->display_as('Correo','Correo del provedor');
							
						
						
						$crud->fields('Nombre','Apellidos','Correo');
						
						
						$crud->unset_bootstrap();
						
						$crud->unset_delete();
						$crud->unset_edit();
						//$crud->unset_jquery();
						//$crud->add_action('Enviar Confirmacion', '', '','fa fa-envelope-o"', array($this,'_admin'));
						
						$output = $crud->render();

						$this->_example_output($output,null);
						
						



					}
					catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}

	
		}


		function Usuarios()
					
                    {
						 $this->load->library('session');
						 	 $email=$this->session->userdata('email');

							$provedor=$this->provedores->get_user_id($email);

				 	try{
						
						$this->db = $this->load->database("default", TRUE);
						
						$crud = new grocery_CRUD();
						
						$crud->set_theme('bootstrap');
						$crud->set_table('users');
						$crud->set_primary_key('id'); // Indicar el campo Llave
						//$crud->where('users_id',$provedor['id']);
						$crud->set_subject('Provedores del Sistema');
						//$crud->required_fields('Provedores del Sistema');
						
						
						$crud->columns('Nombre','Apellidos','Correo','Telefono','Direccion','nivel_id','users_id'); 
						$crud->display_as('Nombre','Nombre del Usuario');
						$crud->display_as('Apellidos','Apellidos del Usuario');
						$crud->display_as('Direccion','Direccion del Usuario');
						$crud->display_as('Correo','Correo del Usuario');
						$crud->display_as('Telefono','Telefono del Usuario');
						
						$crud->display_as('Direccion','Direccion del Usuario');
						
						$crud->display_as('nivel_id','Tipo Usuario');
						
						$crud->display_as('users_id','Provedor');
							
							
						
						
						$crud->fields('Nombre','Apellidos','Correo','nivel_id','users_id');

						$crud->set_primary_key('id','provedores');
									$crud->set_relation('users_id','provedores','Correo');
						
						
						$crud->unset_bootstrap();
						
						//$crud->unset_delete();
						$crud->unset_edit();
						//$crud->unset_jquery();
						$crud->add_action('Enviar Confirmacion', '', '','fa fa-envelope-o"', array($this,'_admin'));
						
						$output = $crud->render();

						$this->_example_output($output,null);
						
						



					}
					catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
					
					}



		function Clientes()
					
                    {
							$this->load->library('session');
						 	 $email=$this->session->userdata('email');

							$provedor=$this->provedores->get_user_id($email);

				 	try{
						
						$this->db = $this->load->database("default", TRUE);
						
						$crud = new grocery_CRUD();
						
						$crud->set_theme('bootstrap');
						$crud->set_table('client');
						$crud->set_primary_key('id'); // Indicar el campo Llave
						//$crud->where('users_id',$provedor['id']);
						$crud->set_subject('Provedores del Sistema');
						//$crud->required_fields('Provedores del Sistema');
						
						
						$crud->columns('Nombre','Apellidos','Correo','Telefono','Empresa','RFC','Direccion','nivel_id','users_id'); 
						$crud->display_as('Nombre','Nombre del Usuario');
						$crud->display_as('Apellidos','Apellidos del Usuario');
						$crud->display_as('Direccion','Direccion del Usuario');
						$crud->display_as('Correo','Correo del Usuario');
						$crud->display_as('Telefono','Telefono del Usuario');
						$crud->display_as('Empresa','Empresa del Usuario');
						$crud->display_as('Direccion','Direccion del Usuario');
						$crud->display_as('RFC','RFC del Usuario');
						$crud->display_as('nivel_id','Tipo Usuario');
						
						$crud->display_as('users_id','Provedor');
							
							
						
						
						$crud->fields('Nombre','Apellidos','Correo','nivel_id','users_id');

						$crud->set_primary_key('id','provedores');
									$crud->set_relation('users_id','provedores','Correo');
						
						
						$crud->unset_bootstrap();
						
						//$crud->unset_delete();
						$crud->unset_edit();
						//$crud->unset_jquery();
						$crud->add_action('Enviar Confirmacion', '', '','fa fa-envelope-o"', array($this,'_admin'));
						
						$output = $crud->render();

						$this->_example_output($output,null);
						
						



					}
					catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
					
					
			}





			function Movimientos()
					
                    {
							 
							 $this->load->library('session');



							 $email=$this->session->userdata('email');

							$provedor=$this->provedores->get_user_id($email);

							$clientes=$this->provedores->get_client_id($provedor['id']);

							$id_clientes;


							foreach ($clientes as $key ) {
								

								$id_clientes=$key['id'];

							}
							
							 	try{
									
									$this->db = $this->load->database("default", TRUE);
									
									$crud = new grocery_CRUD();
									
									$crud->set_theme('bootstrap');
									$crud->set_table('movimientos');
									//$crud->where('id_clients',$id_clientes);
									$crud->set_primary_key('id'); // Indicar el campo Llave
									$crud->set_subject('Clientes del Sistema');
									//$crud->required_fields('Provedores del Sistema');
									
									
									$crud->columns('Movimiento','Confirmacion','Origen','Destino','id_status','id_clients','ruta','Comentarios'); 


									
									$crud->display_as('Movimiento','Movimiento');
									$crud->display_as('Confirmacion','Confirmacion');
									$crud->display_as('Origen','Origen');
									$crud->display_as('id_status','Estado del Movimiento');
									$crud->display_as('ruta','Documento del Movimiento');
									$crud->display_as('Comentarios','Comentarios del Movimiento');
									$crud->display_as('id_clients','Cliente');



									
									
									
									$crud->fields('Movimiento','Confirmacion','Origen','Destino','id_status','id_clients','ruta','Comentarios');


										$crud->set_field_upload('ruta', RUTA_DOCUMENTOS);

									$crud->set_primary_key('id','client');
									$crud->set_relation('id_clients','client','Nombre');

								

									//$crud->where('nivel_id','client');

									$crud->unset_bootstrap();
									//$crud->unset_jquery();
									$crud->add_action('Enviar Confirmacion', '', '','fa fa-envelope-o"', array($this,'_mov'));
									
									$output = $crud->render();

									$this->_example_output($output,null);
									
									



								}
								catch(Exception $e){
									show_error($e->getMessage().' --- '.$e->getTraceAsString());
								}	
					
					}


			function Movimientos_Facturas()
					
                    {
							 
							 $this->load->library('session');



							 $email=$this->session->userdata('email');

							$provedor=$this->provedores->get_user_id($email);

							$clientes=$this->provedores->get_client_id($provedor['id']);

							$movimientos;

							


							$id_clientes;

							$movimiento;


							foreach ($clientes as $key ) {
								

								$id_clientes=$key['id'];

								$movimientos=$this->provedores->get_movimientos_id($id_clientes);

							



							}

							foreach ($movimientos as $key ) {
									$movimiento=$key['id'];


							}



							
							 	try{
									
									$this->db = $this->load->database("default", TRUE);
									
									$crud = new grocery_CRUD();
									
									$crud->set_theme('bootstrap');
									$crud->set_table('movimientos_facturas');
									//$crud->where('id_clients',$id_clientes);
									
									$crud->set_primary_key('id'); // Indicar el campo Llave
									$crud->set_subject('Clientes del Sistema');
									//$crud->required_fields('Provedores del Sistema');
									
									
									$crud->columns('id_movimiento','id_client','pdf','status_factura'); 


									
									$crud->display_as('id_movimiento','Movimiento');
									$crud->display_as('id_client','Cliente');
									$crud->display_as('pdf','Factura');

									$crud->display_as('status_factura','Estado de la Factura');
									

									
									
									
									$crud->fields('id_movimiento','id_client','pdf','status_factura');


										$crud->set_field_upload('pdf', RUTA_DOCUMENTOS);
										$crud->set_field_upload('xml', RUTA_DOCUMENTOS);

									$crud->set_primary_key('id','client');
									$crud->set_relation('id_client','client','Nombre');


									$crud->set_primary_key('id','movimientos');
									$crud->set_relation('id_movimiento','movimientos','movimiento');

								

									//$crud->where('nivel_id','client');

									$crud->unset_bootstrap();
									//$crud->unset_jquery();
									$crud->add_action('Enviar Confirmacion', '', '','fa fa-envelope-o"', array($this,'_movfac'));


									$output = $crud->render();

									$this->_example_output($output,null);
									
									



								}
								catch(Exception $e){
									show_error($e->getMessage().' --- '.$e->getTraceAsString());
								}	
					
					}



		


		function _admin($primary_key, $row)
		{
			
			//$this->Mcontacto->resolver($row->id_coment);
			$tipo="admin";

			return base_url('admin/enviar_correo/'.$row->Correo.'/'.$row->Nombre.'/'.$tipo);
	
			
		}

		function _user($primary_key, $row)
		{
			
			//$this->Mcontacto->resolver($row->id_coment);



			$tipo="user";

			return base_url('admin/enviar_correo/'.$row->Correo.'/'.$row->Nombre.'/'.$tipo);
	
			
		}


		function _cliente($primary_key, $row)
		{
			
			//$this->Mcontacto->resolver($row->id_coment);


			$tipo="client";

			return base_url('admin/enviar_correo/'.$row->Correo.'/'.$row->Nombre.'/'.$tipo);
	
			
		}



		function _mov($primary_key, $row)
		{
			
			//$this->Mcontacto->resolver($row->id_coment);


			

			return base_url('admin/confirm_movimiento/'.$row->Origen.'/'.$row->Destino.'/'.$row->Movimiento.'/'.$row->id_clients);
	
			
		}


		function _movfac($primary_key, $row)
		{
			
			//$this->Mcontacto->resolver($row->id_coment);


			

			return base_url('admin/confirm_movimientos/'.$row->id_movimiento.'/'.$row->id_client);
	
			
		}




			function enviar_correo($correo,$nombre,$tipo){
					
		switch ($tipo) {
			case 'admin':
					$denombre="Glo Logistics";
                    $deemail="soporte@glologistics.com";
                    $sfrom="soporte@glologistics.com"; //cuenta que envia
                    $sdestinatario=$correo; //cuenta destino
                    $ssubject="Estimado Administrador"." ".$nombre; //subject
                    $shtml="Glo Logistics te da la bienvenida a su portal Transportation Managment
					System (TMS), para terminar su registro ingrese a este url. 
					http://glologistics.com.mx/php/admin.php"; 
                    $encabezados = "MIME-Version: 1.0\n";
                    $encabezados .= "Content-type: text/html; charset=iso-8859-1\n";
                    $encabezados .= "From: $denombre <$deemail>\n";
                    $encabezados .= "X-Sender: <$sfrom>\n";
                   
                    $encabezados .= "X-Mailer: PHP\n";
                    $encabezados .= "X-Priority: 1\n"; // fijo prioridad
                    $encabezados .= "Return-Path: <$sfrom>\n";
                    mail($sdestinatario,$ssubject,$shtml,$encabezados);
			
				break;

			case 'user':

					$denombre="Glo Logistics";
                    $deemail="soporte@glologistics.com";
                    $sfrom="soporte@glologistics.com"; //cuenta que envia
                    $sdestinatario=$correo; //cuenta destino
                    $ssubject="Estimado Usuario"." ".$nombre; //subject
                    $shtml="Glo Logistics te da la bienvenida a su portal Transportation Managment
					System (TMS), para terminar su registro ingrese a este url. 
					http://glologistics.com.mx/php/user.php"; 
                    $encabezados = "MIME-Version: 1.0\n";
                    $encabezados .= "Content-type: text/html; charset=iso-8859-1\n";
                    $encabezados .= "From: $denombre <$deemail>\n";
                    $encabezados .= "X-Sender: <$sfrom>\n";
                   
                    $encabezados .= "X-Mailer: PHP\n";
                    $encabezados .= "X-Priority: 1\n"; // fijo prioridad
                    $encabezados .= "Return-Path: <$sfrom>\n";
                    mail($sdestinatario,$ssubject,$shtml,$encabezados);


				# code...
					
				break;

			case 'client':
				# code...

					$denombre="Glo Logistics";
                    $deemail="soporte@glologistics.com";
                    $sfrom="soporte@glologistics.com"; //cuenta que envia
                    $sdestinatario=$correo; //cuenta destino
                    $ssubject="Estimado Administrador"." ".$nombre; //subject
                    $shtml="Glo Logistics te da la bienvenida a su portal Transportation Managment
					System (TMS), para terminar su registro ingrese a este url. 
					http://glologistics.com.mx/php/clientes.php"; 
                    $encabezados = "MIME-Version: 1.0\n";
                    $encabezados .= "Content-type: text/html; charset=iso-8859-1\n";
                    $encabezados .= "From: $denombre <$deemail>\n";
                    $encabezados .= "X-Sender: <$sfrom>\n";
                   
                    $encabezados .= "X-Mailer: PHP\n";
                    $encabezados .= "X-Priority: 1\n"; // fijo prioridad
                    $encabezados .= "Return-Path: <$sfrom>\n";
                    mail($sdestinatario,$ssubject,$shtml,$encabezados);
				break;
			
			default:
				# code...
				break;
		}

		redirect(base_url('admin'));



		}

		function Contacto(){
					 $this->load->library('session');

				$pagina="admin/web/contact";
				$app="Home";
				$name="GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0";
				$title="Mis Horarios";			
			
		 		$this->_example_output((object)array('name'=>$name,'title'=>$title,'pagina_interna'=>$pagina,'output' => '', 'js_files' =>array(), 'css_files' => array(), 'app' => $app,'name'=>$name,$title=>'GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0'),(object)array('pagina_interna'=>$pagina,'title'=>$title,'output' => '', 'js_files' =>array(), 'css_files' => array(), 'app' => $app,'name'=>$name,$title=>'GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0')  );
				

		}

		function Profile(){
					 $this->load->library('session');

					 $email=$this->session->userdata('email');

					  $perfil=$this->provedores->get_master($email);

					 

				$pagina="admin/web/profile";
				$app="Home";
				$name="GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0";
				$title="Mis Horarios";			
			
		 		$this->_example_output((object)array('name'=>$name,'title'=>$title,'pagina_interna'=>$pagina,'output' => '', 'js_files' =>array(), 'css_files' => array(), 'app' => $app,'name'=>$name,$title=>'GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0'),(object)array('pagina_interna'=>$pagina,'perfil'=>$perfil,'title'=>$title,'output' => '', 'js_files' =>array(), 'css_files' => array(), 'app' => $app,'name'=>$name,$title=>'GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0')  );
				

		}


		function confirm_movimiento($origen,$destino,$movimiento,$id_clients){
			
					 $this->load->library('session');

				$pagina="admin/web/movimiento_form";
				$app="Home";
				$name="GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0";
				$title="Mis Horarios";
				$data['origen']=$origen;

				$co=$this->provedores->get_emalil($id_clients);
				

			
		 		$this->_example_output((object)array('name'=>$name,'title'=>$title,'movimiento'=>$movimiento,'origen'=>$origen,'destino'=>$destino,'pagina_interna'=>$pagina,'output' => '', 'js_files' =>array(), 'css_files' => array(), 'app' => $app,'movimiento'=>$movimiento,'origen'=>$origen,'destino'=>$destino,'name'=>$name,$title=>'GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0'),(object)array('pagina_interna'=>$pagina,'co'=>$co['Correo'],'movimiento'=>$movimiento,'origen'=>$origen,'destino'=>$destino,'title'=>$title,'output' => '', 'js_files' =>array(), 'css_files' => array(), 'app' => $app,'name'=>$name,$title=>'GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0')  );
		}



		function confirm_movimientos($movimiento,$cliente){
			
					 $this->load->library('session');
				$pagina="admin/web/movimiento_fac_form";
				
				$app="Home";
				$name="GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0";
				$title="Mis Horarios";
				$data['origen']=$origen;

				$co=$this->provedores->get_factura($movimiento);
				
				foreach ($co as $key ) {
								

								$movimientos=$key['Movimiento'];
								$cliente=$key['Nombre'];
								$co_clien=$key['Correo'];



							}

		 		$this->_example_output((object)array('name'=>$name,'title'=>$title,'movimiento'=>$movimiento,'origen'=>$origen,'destino'=>$destino,'pagina_interna'=>$pagina,'output' => '', 'js_files' =>array(), 'css_files' => array(), 'app' => $app,'movimiento'=>$movimiento,'origen'=>$origen,'destino'=>$destino,'name'=>$name,$title=>'GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0'),(object)array('pagina_interna'=>$pagina,'co'=>$co_clien,'movimiento'=>$movimientos,'client'=>$cliente,'title'=>$title,'output' => '', 'js_files' =>array(), 'css_files' => array(), 'app' => $app,'name'=>$name,$title=>'GLO TRASPORTATON MANAGMENT SYSTEM TMS v2.0')  );
		}



		function enviar_contact(){


			
			
			



			$nombre=$this->input->post('nombre');
			$correo=$this->input->post('correo');
			$mesaje=$this->input->post('message');
			$asunto=$this->input->post('subject');


					$denombre="Glo Logistics";
                    $deemail="soporte@glologistics.com";
                    $sfrom="soporte@glologistics.com"; //cuenta que envia
                    $sdestinatario=$correo; //cuenta destino
                    $ssubject="El usuario quiere contactarse ".$nombre; //subject
                    $shtml=$mesaje; 
                    $encabezados = "MIME-Version: 1.0\n";
                    $encabezados .= "Content-type: text/html; charset=iso-8859-1\n";
                    $encabezados .= "From: $denombre <$deemail>\n";
                    $encabezados .= "X-Sender: <$sfrom>\n";
                   
                    $encabezados .= "X-Mailer: PHP\n";
                    $encabezados .= "X-Priority: 1\n"; // fijo prioridad
                    $encabezados .= "Return-Path: <$sfrom>\n";
                    mail($sdestinatario,$ssubject,$shtml,$encabezados);

                    redirect(base_url('admin'));



		}



		function enviar_movimiento(){


			$origen=$this->input->post('origen');
			$destino=$this->input->post('destino');
			$cc=$this->input->post('cc');
			$c1=$this->input->post('c1');
			$c2=$this->input->post('c2');
			$c3=$this->input->post('c3');
			
			$mensaje=$this->input->post('mensaje');

			$correos=array($c1,$c2,$c3,$c4);






					$denombre="Glo Logistics";
                    $deemail="soporte@glologistics.com";
                    $sfrom="soporte@glologistics.com"; //cuenta que envia
                    $sBCC=$cc; //me envio una copia oculta
                    $sBCCo=$correos; //me envio una copia oculta
                    $sdestinatario=$cc; //cuenta destino
                    $ssubject="Nuevo Movimiento Registrado"; //subject
                    $shtml=$mensaje." ". $origen."  "." y con un destino a"." ".$Destino; 
                    $encabezados = "MIME-Version: 1.0\n";
                    $encabezados .= "Content-type: text/html; charset=iso-8859-1\n";
                    $encabezados .= "From: $denombre <$deemail>\n";
                    $encabezados .= "X-Sender: <$sfrom>\n";
                    $encabezados .= "BCC: <$sBCC>\n"; //aqui fijo el BCC
                    $encabezados .= "BCco: <$sBCCo>\n"; //aqui fijo el BCCo
                    $encabezados .= "X-Mailer: PHP\n";
                    $encabezados .= "X-Priority: 1\n"; // fijo prioridad
                    $encabezados .= "Return-Path: <$sfrom>\n";
                    mail($sdestinatario,$ssubject,$shtml,$encabezados);

                     $this->repetir($mensaje,$c3);
		}




		function enviar_movimientos(){


			$movimiento=$this->input->post('movimiento');
			$cliente=$this->input->post('client');
			$cc=$this->input->post('cc');
			$c1=$this->input->post('c1');
			$c2=$this->input->post('c2');
			$c3=$this->input->post('c3');
			
			$mensaje=$this->input->post('mensaje');

			$correos=array($c1,$c2,$c3);




					$denombre="Glo Logistics";
                    $deemail="soporte@glologistics.com";
                    $sfrom="soporte@glologistics.com"; //cuenta que envia
                    $sBCC=$cc; //me envio una copia oculta
                    $sBCCo=$correos; //me envio una copia oculta
                    $sdestinatario=$cc; //cuenta destino
                    $ssubject="Nueva Confirmacion Registrada"; //subject
                    $shtml=$mensaje; 
                    $encabezados = "MIME-Version: 1.0\n";
                    $encabezados .= "Content-type: text/html; charset=iso-8859-1\n";
                    $encabezados .= "From: $denombre <$deemail>\n";
                    $encabezados .= "X-Sender: <$sfrom>\n";
                    $encabezados .= "BCC: <$sBCC>\n"; //aqui fijo el BCC
                    $encabezados .= "BCco: <$sBCCo>\n"; //aqui fijo el BCCo
                    $encabezados .= "X-Mailer: PHP\n";
                    $encabezados .= "X-Priority: 1\n"; // fijo prioridad
                    $encabezados .= "Return-Path: <$sfrom>\n";
                    mail($sdestinatario,$ssubject,$shtml,$encabezados);


                    $this->repetir_mo($mensaje,$c3);
                   
		}



		function repetir($mensaje,$c3){
		
                  	
		    $denombre="Glo Logistics";
                    $deemail="soporte@glologistics.com";
                    $sfrom="soporte@glologistics.com"; //cuenta que envia
                    //$sBCC=$c2; //me envio una copia oculta
                    //$sBCCo=$c1; //me envio una copia oculta
                    $sdestinatario=$c3; //cuenta destino
                    $ssubject="Nuevo Movimiento Registrado"; //subject
                    $shtml=$mensaje; 
                    $encabezados = "MIME-Version: 1.0\n";
                    $encabezados .= "Content-type: text/html; charset=iso-8859-1\n";
                    $encabezados .= "From: $denombre <$deemail>\n";
                    $encabezados .= "X-Sender: <$sfrom>\n";
                   // $encabezados .= "BCC: <$sBCC>\n"; //aqui fijo el BCC
                   // $encabezados .= "BCco: <$sBCCo>\n"; //aqui fijo el BCCo
                    $encabezados .= "X-Mailer: PHP\n";
                    $encabezados .= "X-Priority: 1\n"; // fijo prioridad
                    $encabezados .= "Return-Path: <$sfrom>\n";
                    mail($sdestinatario,$ssubject,$shtml,$encabezados);


			 redirect(base_url('admin'));


		}




		function repetir_mo($mensaje,$c3){
		
                  	
		    $denombre="Glo Logistics";
                    $deemail="soporte@glologistics.com";
                    $sfrom="soporte@glologistics.com"; //cuenta que envia
                    //$sBCC=$c2; //me envio una copia oculta
                    //$sBCCo=$c1; //me envio una copia oculta
                    $sdestinatario=$c3; //cuenta destino
                    $ssubject="Nuevo Movimiento Registrado"; //subject
                    $shtml=$mensaje; 
                    $encabezados = "MIME-Version: 1.0\n";
                    $encabezados .= "Content-type: text/html; charset=iso-8859-1\n";
                    $encabezados .= "From: $denombre <$deemail>\n";
                    $encabezados .= "X-Sender: <$sfrom>\n";
                   // $encabezados .= "BCC: <$sBCC>\n"; //aqui fijo el BCC
                   // $encabezados .= "BCco: <$sBCCo>\n"; //aqui fijo el BCCo
                    $encabezados .= "X-Mailer: PHP\n";
                    $encabezados .= "X-Priority: 1\n"; // fijo prioridad
                    $encabezados .= "Return-Path: <$sfrom>\n";
                    mail($sdestinatario,$ssubject,$shtml,$encabezados);


			 redirect(base_url('admin'));


		}








		

}







 ?>