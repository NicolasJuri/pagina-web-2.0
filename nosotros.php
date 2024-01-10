<?php include("template/cabecera.php"); ?>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
<link rel="stylesheet" href="./css/bootstrap.min.css" />


<div class="container">
  <div id="image-carousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="img/mix2-slider.png" class="d-block w-100" alt="Imagen 1">
      </div>
      <div class="carousel-item">
        <img src="img/titulo-slide.png" class="d-block w-100" alt="Imagen 2">
      </div>
      <div class="carousel-item">
        <img src="img/sal-himalaya.jpg" class="d-block w-100" alt="Imagen 3">
      </div>
    </div>
    <div class="fixed2-title-container">
      <img src="img/logo3.png" class="fixed-title-image" alt="Imagen fija">
    </div>
  </div>
</div>

<hr class="my-2 mt-4 mb-4">

<div class="jumbotron">
    <p class="lead"><h3 class="text-center">10 años de Experiencia</h3><br>
OKS es una distribuidora mayorista de golosinas y artículos para Kioscos, en la cual nos esforzamos por brindar un servicio de calidad entregando en tiempo y forma productos de relevancia nuestros clientes.<br>
Contamos con venta presencial en todo Capital Federal mediante preventistas y logística propia para entregas en CABA y GBA.<br>
Nuestros clientes son todo tipo de Kioscos, Mini Mercados, Almacenes, Ferreterías, Empresas y todos aquellos comercios que requieran algunos de nuestros productos.<br>
<br>
<h3 class="text-center">Historia</h3><br>
 
En el año 2005, más precisamente el 17 de Octubre, se comienza a forjar OKS.<br>
Con 27 años, y mucho entusiasmo, Diego inicia su actividad en la compra y venta de artículos para kiosco. El inicio fue de manera personal, haciéndose cargo de las compras, la venta, el armado de los pedidos, la entrega de los mismos. La modalidad de venta, tan sencilla como milenaria, venta ambulante, con mercadería en stock en un carro desarrollado para ese fin.<br>
Al principio almacenaba mercadería en la baulera de su casa y pronto se alquiló un pequeño local en una galería comercial sobre la calle Lavalle, en plena zona de tribunales.<br>
El tiempo fue pasando, el negocio fue creciendo y el desarrollo del mismo no se hizo esperar. Se incorporó primero un vendedor, y luego otro. Más tarde no alcanzaba con esto, y la cartera de clientes desarrollada exigía más y más surtido. Así uno de los carros se transformó en un ciclomotor cargo. Ya no alcanzaba ese pequeño depósito.<br>
Las entregas se comenzaron a hacer en camionetas contratadas, hasta que en el año 2007 se adquiere el primer vehículo propio.<br>
En el año 2009, ese emprendimiento personal, se transformó en Once Kioscos Service S.R.L.<br>
En 2010 OKS da su primer gran paso mudándose a un depósito de 300 m2 y oficinas comerciales en el barrio de Monserrat (Congreso).<br>
Entre 2010 y 2012 las industrias valoran nuestro trabajo de distribución y nacen los primeros acuerdos comerciales con empresas como Energizer y Chocoarroz (Molinos Rio de la Plata).<br>
En 2020, durante la pandemia, OKS nunca deja de trabajar y realiza grandes esfuerzos para llevar soluciones a los comercios, incorporando artículos de primera necesidad.<br>
Durante ese año el crecimiento fue constante y la estructura necesitaba ampliarse nuevamente. <br>
En 2021 se lleva a cabo el salto más grande. OKS se muda a un nuevo depósito con 4 veces más de metros cuadrados y 10 veces más de posiciones de pallets, lo que nos permitió armar, almacenar y comercializar 30.000 cajas navideñas.<br>
<br>
<h3 class="text-center">Misión</h3><br>
Nuestra misión es ofrecer el mejor servicio de venta y distribución, generando valor a nuestros proveedores y clientes, diferenciándonos por la dedicación en lo que hacemos, dentro de un ambiente laboral sano, distendido y agradable para nuestros empleados, clientes, proveedores y medio ambiente.</p>
</div>



<a href="#" class="scroll-to-top">
  <i class="fas fa-arrow-up"></i>
</a>


<style>

.carousel-inner {
  position: relative;
}

.carousel-item {
  position: relative;
}

.fixed2-title-container {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.fixed-title-image {
  width: 510px;
  height: 155px;
}

@media (max-width: 768px) {

  .fixed-title-image {
    width: 100%; /* Ajusta el tamaño de la imagen según tus necesidades */
    max-width: 510px;
    height: 100%;
  }
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

<?php include("template/pie.php"); ?>