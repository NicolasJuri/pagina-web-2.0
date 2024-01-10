<?php include("template/cabecera.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="./css/bootstrap.min.css" />

<?php
include("administrador/config/bd.php");

$sentenciaSQL = $conexion->prepare("SELECT * FROM productos");
$sentenciaSQL->execute();
$listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="container">
  <div id="image-carousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="img/frutas-titulo.png" class="d-block w-100" alt="Imagen 1">
      </div>
      <div class="carousel-item">
        <img src="img/cereales-titulo.png" class="d-block w-100" alt="Imagen 2">
      </div>
      <div class="carousel-item">
        <img src="img/legumbres.png" class="d-block w-100" alt="Imagen 3">
      </div>
      <div class="carousel-item">
        <img src="img/legumbres.png" class="d-block w-100" alt="Imagen 3">
      </div>
    </div>
    <div class="fixed-title-container">
      <img src="img/logo2.png" class="fixed-title-image" alt="Imagen fija">
    </div>
  </div>
</div>

<hr class="my-2 mt-4 mb-4">

<div class="container mb-5">
  <div class="row justify-content-end">
    <div class="col-md-4">
      <div class="form-group">
        <input type="text" id="buscador" class="form-control" placeholder="Buscar...">
      </div>
    </div>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th class="text-center">Producto</th>
        <th class="text-center">Imagen</th>
        <th class="text-center d-none d-sm-table-cell d-md-table-cell">Categoria</th>
        <th class="text-center">Precio</th>
        <th class="text-center d-none d-sm-table-cell d-md-table-cell">Comentarios</th>
        <th class="text-center">Cantidad</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($listaProductos as $producto) { ?>
        <?php
        $comentario = $producto['comentarios']; // Obtener el comentario

        // Verificar si el comentario contiene la palabra "oferta"
        $isOferta = (stripos($comentario, 'oferta') !== false);

        // Verificar si el comentario contiene "sin stock" o "SIN STOCK"
        $sinStock = (stripos($comentario, 'sin stock') !== false) || (stripos($comentario, 'SIN STOCK') !== false);
        ?>
        <tr <?php echo $isOferta ? 'style="background-color: #efa229; color: white; font-weight: bold;"' : ''; ?>>
          <td><?php echo $isOferta ? strtoupper($producto['nombre']) : $producto['nombre']; ?></td>
          <td class="text-center">
            <i class="fas fa-eye text-center" style="cursor: pointer;" onclick="mostrarLaImagen('<?php echo "./img/" . $producto['imagen']; ?>');" alt=""></i>
          </td>
          <td class="text-center d-none d-sm-table-cell d-md-table-cell"><?php echo $isOferta ? strtoupper($producto['categoria']) : $producto['categoria']; ?></td>
          <td class="text-center"><?php echo $producto['precio']; ?></td>
          <td class="text-center d-none d-sm-table-cell d-md-table-cell"><?php echo $isOferta ? strtoupper($comentario) : $comentario; ?></td>
          <td class="text-center">
            <input type="number" min="1" value="0" class="form-control cantidad" data-precio="<?php echo $producto['precio']; ?>">
          </td>
          <td class="text-center d-flex justify-content-between">
            <?php if ($sinStock) { ?>
              <button class="btn btn-primary borrar-carrito mb-1" data-id="<?php echo $producto['id']; ?>" disabled><span class="fa fa-minus"></span></button>
              <span style="margin-right: 4px; margin-left: 3px;">Pedir</span>
              <button class="btn btn-primary agregar-carrito mb-1" data-id="<?php echo $producto['id']; ?>" disabled><span class="fa fa-plus"></span></button>
            <?php } else { ?>
              <button onclick="abrirModal();" class="btn btn-primary borrar-carrito mb-1" data-id="<?php echo $producto['id']; ?>"><span class="fa fa-minus"></span></button>
              <span style="margin-right: 4px; margin-left: 3px;">Pedir</span>
              <button onclick="abrirModal();" class="btn btn-primary agregar-carrito mb-1" data-id="<?php echo $producto['id']; ?>"><span class="fa fa-plus"></span></button>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>





<div id="imagenModal" class="modal">
  <span class="close" onclick="cerrarElModal()">&times;</span>
  <img class="modal-content" id="imagenProducto">
</div>

<script>
  function mostrarLaImagen(urlImagen) {
    var modal = document.getElementById('imagenModal');
    var imagen = document.getElementById('imagenProducto');
    imagen.src = urlImagen;
    modal.style.display = "block";
  }

  function cerrarElModal() {
    var modal = document.getElementById('imagenModal');
    modal.style.display = "none";
  }
</script>

<style>

  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 50px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.9);
  }

  .modal-content {
    margin: auto;
    display: block;
    width: 500px;
    max-width: 100%;
    height: auto;
    max-height: 500px;
  }

  .close {
    color: #fff;
    position: absolute;
    top: 15px;
    right: 35px;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
  }
</style>



<a href="#" class="scroll-to-top">
  <i class="fas fa-arrow-up"></i>
</a>



<script>
$(document).ready(function() {
  $('#buscador').on('keyup', function() {
    var value = $(this).val().toLowerCase();
    $('table tbody tr').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>



<script>
$(document).ready(function() {
    var productosAgregados = []; // Arreglo para almacenar los productos agregados

    $('.agregar-carrito').click(function() {
        var nombre = $(this).closest('tr').find('td:eq(0)').text();
        var cantidad = parseInt($(this).closest('tr').find('.cantidad').val());
        var precio = parseInt($(this).closest('tr').find('.cantidad').data('precio'));
        var total = cantidad * precio;
        var id = $(this).data('id');

        var producto = {
            id: id,
            nombre: nombre,
            cantidad: cantidad,
            precio: precio,
            total: total
        };

        // Verificar si el producto ya está en el carrito
        var productoExistente = productosAgregados.find(function(producto) {
            return producto.id === id;
        });

        if (productoExistente) {
            // Si el producto ya existe, actualizar la cantidad y el total
            productoExistente.cantidad += cantidad;
            productoExistente.total = productoExistente.cantidad * productoExistente.precio;
        } else {
            // Si el producto no existe, agregarlo al carrito
            productosAgregados.push(producto);
        }


        mostrarProductosAgregados();
        $('.borrar-carrito').prop('disabled', false); // Habilitar el botón "borrar-carrito"
    });

    $(document).on('click', '.borrar-carrito', function() {
        var idProducto = $(this).data('id');
        var cantidad = parseInt($(this).closest('tr').find('.cantidad').val());

        borrarCantidadDelCarrito(idProducto, cantidad);
        });

function borrarCantidadDelCarrito(idProducto, cantidad) {
    var productoExistente = productosAgregados.find(function(producto) {
        return producto.id === idProducto;
    });

    if (productoExistente) {
        productoExistente.cantidad -= cantidad;

        if (productoExistente.cantidad <= 0) {
            productosAgregados = productosAgregados.filter(function(producto) {
                return producto.id !== idProducto;
            });
        } else {
            productoExistente.total = productoExistente.cantidad * productoExistente.precio;
        }
    }

    mostrarProductosAgregados();
}


    function mostrarProductosAgregados() {
        var tablaProductos = $('#tabla-productos tbody');
        tablaProductos.empty(); // Limpiar la tabla antes de mostrar los productos

        var totalPedido = 0;

        for (var i = 0; i < productosAgregados.length; i++) {
            var producto = productosAgregados[i];
            var fila = '<tr>' +
                '<td>' + producto.nombre + '</td>' +
                '<td>' + producto.cantidad + '</td>' +
                '<td>' + producto.precio + '</td>' +
                '<td>' + producto.total + '</td>' +
                '</tr>';

            tablaProductos.append(fila); // Agregar la fila a la tabla

            totalPedido += producto.total;
        }

        $('#total-pedido').text('Total Pedido: ' + totalPedido); // Mostrar el total del pedido
    }

    $('.table').find('tbody').find('tr').each(function() {
        var precio = parseInt($(this).find('td:eq(2)').text());

        if (precio === 0) {
            $(this).find('.agregar-carrito').prop('disabled', true);
            $(this).find('.borrar-carrito').prop('disabled', true);
        }
    });

    $(document).on('click', '#enviar-pedido', function() {
    var cliente = $('#nombre-input').val(); // Obtener el valor del campo de entrada de nombre

    var mensaje = '¡Hola soy ' + cliente + '! y quiero realizar este pedido:\n\n';
    var totalPedido = 0;
    for (var i = 0; i < productosAgregados.length; i++) {
        var producto = productosAgregados[i];
        var subtotal = producto.cantidad * producto.precio;
        mensaje += '- ' + producto.nombre + ' (Cantidad: ' + producto.cantidad + ', Subtotal: ' + subtotal + ')\n';
        totalPedido += subtotal;
    }
    mensaje += '\nTotal Pedido: ' + totalPedido;

    // Obtener el número de WhatsApp
    var numeroWhatsApp = '543434703063'; // Reemplaza "TUNUMERO" por el número de WhatsApp de tu empresa

    // Construir la URL de WhatsApp con el mensaje predefinido
    var encodedMensaje = encodeURIComponent(mensaje);
    var url = 'https://wa.me/' + numeroWhatsApp + '?text=' + encodedMensaje;

    // Abrir el enlace de WhatsApp en una nueva ventana
    window.open(url, '_blank');
});




$(document).on('click', '#borrar-pedido', function() {
        productosAgregados = []; // Vaciar el arreglo de productos agregados
        mostrarProductosAgregados(); // Actualizar la lista de productos agregados en el modal
        $('.borrar-carrito').prop('disabled', true); // Deshabilitar el botón "borrar-carrito"
});


});

function abrirModal() {
  var modalDiv = document.createElement('div');
  modalDiv.className = 'modal modal-custom';

  var modalContent = document.createElement('div');
  modalContent.className = 'modal-content modal-custom-content';

  var closeModalButton = document.createElement('span');
  closeModalButton.className = 'close';
  closeModalButton.innerHTML = '&times;';
  closeModalButton.onclick = function() {
    modalDiv.style.display = 'none';
  };

  var titulo = document.createElement('h5');
  titulo.textContent = 'Tu pedido';
  titulo.className = 'text-center';

  var table = document.createElement('table');
  table.id = 'tabla-productos';
  table.className = 'table table-bordered';
  var thead = document.createElement('thead');
  var tr = document.createElement('tr');
  var th1 = document.createElement('th');
  th1.className = 'text-center';
  th1.textContent = 'Producto';
  var th2 = document.createElement('th');
  th2.className = 'text-center';
  th2.textContent = 'Cantidad';
  var th3 = document.createElement('th');
  th3.className = 'text-center';
  th3.textContent = 'Precio';
  var th4 = document.createElement('th');
  th4.className = 'text-center';
  th4.textContent = 'Total';

  tr.appendChild(th1);
  tr.appendChild(th2);
  tr.appendChild(th3);
  tr.appendChild(th4);
  thead.appendChild(tr);
  table.appendChild(thead);

  var tbody = document.createElement('tbody');
  tbody.id = 'lista-productos';
  table.appendChild(tbody);

  var totalPedido = document.getElementById('total-pedido');
  if (!totalPedido) {
    totalPedido = document.createElement('p');
    totalPedido.id = 'total-pedido';
    modalContent.appendChild(totalPedido);
  }
  totalPedido.textContent = ''; // Limpiar contenido anterior

  var nombreInput = document.createElement('input');
  nombreInput.id = 'nombre-input';
  nombreInput.type = 'text';
  nombreInput.placeholder = 'Ingrese su nombre';
  nombreInput.className = 'form-control mb-3';
  nombreInput.required = true;

  var buttonsContainer = document.createElement('div');
  buttonsContainer.className = 'd-flex justify-content-between'; // Contenedor flexbox

  var enviarPedidoButton = document.createElement('button');
  enviarPedidoButton.id = 'enviar-pedido';
  enviarPedidoButton.className = 'btn btn-success justify-content-center';
  enviarPedidoButton.style.width = '200px';
  enviarPedidoButton.innerHTML = '<i class="fab fa-whatsapp mr-2"></i> Enviar pedido';

  var seguirComprandoButton = document.createElement('button');
  seguirComprandoButton.id = 'seguir-comprando';
  seguirComprandoButton.className = 'btn btn-primary justify-content-center';
  seguirComprandoButton.style.width = '200px';
  seguirComprandoButton.innerHTML = '<i class="fas fa-cart-arrow-down mr-2"></i> Seguir comprando';

  var borrarButton = document.createElement('i');
  borrarButton.id = 'borrar-pedido';
  borrarButton.className = 'fas fa-trash-alt';
  borrarButton.style.color = 'red';
  borrarButton.style.marginTop = '11px';

  borrarButton.addEventListener('click', function() {
    var selectedElements = document.querySelectorAll('.selected');
    selectedElements.forEach(function(element) {
      element.parentNode.removeChild(element);
    });
  });

  seguirComprandoButton.addEventListener('click', function() {
    modalDiv.style.display = 'none';
  });

  buttonsContainer.appendChild(enviarPedidoButton);
  buttonsContainer.appendChild(borrarButton);
  buttonsContainer.appendChild(seguirComprandoButton);

  var buttonsWrapper = document.createElement('div');
  buttonsWrapper.className = 'text-center mt-3';

  buttonsWrapper.appendChild(buttonsContainer);

  modalContent.appendChild(closeModalButton);
  modalContent.appendChild(titulo);
  modalContent.appendChild(table);
  modalContent.appendChild(totalPedido);
  modalContent.appendChild(nombreInput);
  modalContent.appendChild(buttonsWrapper);

  modalDiv.appendChild(modalContent);

  document.body.appendChild(modalDiv);

  var windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
  var modalHeight = modalDiv.offsetHeight;
  var marginTop = (windowHeight - modalHeight) / 4;

  modalContent.style.marginTop = marginTop + 'px';

  modalDiv.style.display = 'block';
}


</script>

<style>

.carousel-inner {
  position: relative;
}

.carousel-item {
  position: relative;
}

.fixed-title-container {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.fixed-title-image {
  width: 663px;
  height: 175px;
}

@media (max-width: 768px) {
  .fixed-title-image {
    width: 120%; /* Ajusta el tamaño de la imagen según tus necesidades */
    max-width: 663px;
    height: auto;
  }
}


.modal-custom {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-custom-content {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
}

    .card {
        margin-right: 15px;
    }
  .carousel-item img {
    height: 300px;
    object-fit: cover;
    filter: brightness(100%); /* Elimina el efecto de desenfoque */
  }

  .fixed-title {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
    color: black;
    text-shadow: 0 0 10px rgba(255, 255, 255, 1); /* Ajusta la opacidad a 1 */
  }

  .scroll-to-top {
  position: fixed;
  bottom: 20px;
  right: 20px;
  display: none;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: #f8f9fa;
  text-align: center;
  line-height: 40px;
  color: #333;
  z-index: 9999;
  transition: opacity 0.3s ease-in-out;
}

.scroll-to-top:hover {
  opacity: 0.7;
}

.scroll-to-top i {
  font-size: 20px;
}

.scroll-to-top.show {
  display: block;
}

</style>


<script>
  // Configuración del carrusel
  var carousel = new bootstrap.Carousel(document.querySelector('#image-carousel'), {
    interval: 3000, // Cambia la imagen cada 3 segundos (ajústalo según tus necesidades)
    pause: false // No pausar el carrusel al pasar el cursor sobre él
  });
</script>
<script>
window.addEventListener("scroll", function () {
    var scrollButton = document.querySelector(".scroll-to-top");
    if (window.pageYOffset > 100) {
      scrollButton.classList.add("show");
    } else {
      scrollButton.classList.remove("show");
    }
  });

  document.querySelector(".scroll-to-top").addEventListener("click", function (e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
</script>


<!-- Empieza el chatbot... -->

<div class="row justify-content-center mt-4">
  <div class="col-md-6">
    <div class="form-group text-center">
      <div class="chatbot-image" onclick="mostrarCampoPregunta();">
        <div class="speech-bubble user-bubble">
          <span>Hola! Soy Guara, mi función es ayudarte, haz click aquí para hacer tu consulta.</span>
          <br>
          <input type="text" id="preguntaInput" placeholder="Haz una pregunta..." />
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row justify-content-center mt-4">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body" id="respuesta">
        <!-- Aquí se mostrarán las respuestas del bot -->
      </div>
    </div>
  </div>
</div>

<script>
  function manejarRespuesta(respuesta) {
    var respuestaDiv = document.getElementById('respuesta');
    respuestaDiv.innerHTML = respuesta;
  }

  function mostrarCampoPregunta() {
    var preguntaInput = document.getElementById('preguntaInput');
    preguntaInput.style.display = 'block';
  }

  function enviarPregunta() {
    var preguntaInput = document.getElementById('preguntaInput');
    var pregunta = preguntaInput.value.trim();

    if (pregunta !== '') {
      manejarRespuesta('Tú: ' + pregunta);

      var respuesta;

      // Procesar la pregunta y obtener la respuesta
      if (pregunta.toLowerCase().includes('pedido')) {
        respuesta = 'Guara: Para hacer un pedido, selecciona todos los productos que necesites, añádelos al carrito, escribe tu nombre y haz clic en "Enviar Pedido". Luego, se abrirá la página de WhatsApp donde podrás enviar el pedido y nuestro equipo se pondrá en contacto contigo para coordinar la entrega.';
      } else if (pregunta.toLowerCase().includes('horarios')) {
        respuesta = 'Guara: Nuestros horarios de entrega son de lunes a viernes de 9:00 a.m. a 13:00 p.m.';
      } else if (pregunta.toLowerCase().includes('envio')) {
        respuesta = 'Guara: Nuestros envíos son totalmente gratuitos (consultar mínimo).';
      } else if (pregunta.toLowerCase().includes('problema')) {
        respuesta = 'Guara: si tuviste cualquier inconveniente con nuestro servicio podes ponerte en contacto con nosotros al 343-4487301.';
      } else if (pregunta.toLowerCase().includes('descuentos')) {
        respuesta = 'Guara: Regularmente ofrecemos descuentos especiales en nuestros productos. Te recomendamos estar atento a los productos en oferta.';
      } else if (pregunta.toLowerCase().includes('hola')) {
        respuesta = 'Guara: Hola y bienvenid@ a Natural Mix!, como puedo ayudarte?.';
      } else if (pregunta.toLowerCase().includes('chau')) {
        respuesta = 'Guara: Espero haber sido de ayuda, que te vaya bien!';
      } else if (pregunta.toLowerCase().includes('horario')) {
        respuesta = 'Guara: Nuestros horarios de entrega son de lunes a viernes de 9:00 a.m. a 13:00 p.m.';
      } else if (pregunta.toLowerCase().includes('pedidos')) {
        respuesta = 'Guara: Para hacer un pedido, selecciona todos los productos que necesites, añádelos al carrito, escribe tu nombre y haz clic en "Enviar Pedido". Luego, se abrirá la página de WhatsApp donde podrás enviar el pedido y nuestro equipo se pondrá en contacto contigo para coordinar la entrega.';
      } else if (pregunta.toLowerCase().includes('comprar')) {
        respuesta = 'Guara: Para hacer un pedido, selecciona todos los productos que necesites, añádelos al carrito, escribe tu nombre y haz clic en "Enviar Pedido". Luego, se abrirá la página de WhatsApp donde podrás enviar el pedido y nuestro equipo se pondrá en contacto contigo para coordinar la entrega.';      
      } else if (pregunta.toLowerCase().includes('compra')) {
        respuesta = 'Guara: Para hacer un pedido, selecciona todos los productos que necesites, añádelos al carrito, escribe tu nombre y haz clic en "Enviar Pedido". Luego, se abrirá la página de WhatsApp donde podrás enviar el pedido y nuestro equipo se pondrá en contacto contigo para coordinar la entrega.';
      } else if (pregunta.toLowerCase().includes('atencion')) {
        respuesta = 'Guara: Nuestros horarios de atencion son de lunes a viernes de 9:00 a.m. a 17:00 p.m.';
      } else if (pregunta.toLowerCase().includes('local')) {
        respuesta = 'Guara: Nuestro local esta ubicado en calle Uruguay 769.';
      } else if (pregunta.toLowerCase().includes('ubicacion')) {
        respuesta = 'Guara: Nuestro local esta ubicado en calle Uruguay 769.';
      } else {
        respuesta = 'Guara: Lo siento, no puedo responder a esa pregunta en este momento.';
      }

      manejarRespuesta(respuesta);

      // Limpiar el campo de entrada después de enviar la pregunta
      preguntaInput.value = '';
      preguntaInput.style.display = 'none';
    }
  }

  var preguntaInput = document.getElementById('preguntaInput');
  preguntaInput.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
      enviarPregunta();
    }
  });
</script>

<style>
  .chatbot-image {
    width: 150px;
    height: 150px;
    background-image: url('img/almendra-chatbot.jpg');
    background-size: cover;
    cursor: pointer;
    animation: chatbotAnimation 15s infinite alternate;
    position: relative;
  }

  .speech-bubble {
    position: absolute;
    background-color: #f0f0f0;
    padding: 10px;
    border-radius: 10px;
    width: 200px;
    animation: fadeIn 0.5s ease-in-out;
  }

  .user-bubble {
    right: -230px;
  }

  .chatbot-image:hover .speech-bubble {
    display: block;
    animation: fadeIn 0.5s ease-in-out;
  }

  #preguntaInput {
    display: none;
    width: 100%;
    padding: 5px;
    margin-top: 5px;
  }

  @keyframes chatbotAnimation {
    0% { transform: translateX(5px); }
    50% { transform: translateX(-5px); }
    100% { transform: translateX(5px); }
  }

  @keyframes fadeIn {
    0% { opacity: 0; transform: translateY(-10px); }
    100% { opacity: 1; transform: translateY(0); }
  }
</style>





<!-- Termina el chatbot -->



<?php include("template/pie.php"); ?>
