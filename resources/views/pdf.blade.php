<link type="text/css" href="css/bootstrap.css" rel="stylesheet" />
<style>
    @page {
        margin: auto 0px;
        margin-top: 10px;
        margin-bottom: 50px;
    }

    @font-face {
        font-family: 'Roboto' !important;
        font-style: normal;
        font-weight: normal;
        src: url(fonts/Roboto/Roboto-Light.ttf) format('truetype');
    }

    body {
        font-family: 'Roboto', sans-serif !important;
        margin: 0.5cm 0.5cm 0.5cm;
        padding: 0cm;
        border: 1px solid #EBEBEB;
    }

    #header {
        position: fixed;
        top: -120px;
        height: 50px;
        left: 0.5cm;
        right: 0.5cm;
    }

    footer {
        position: fixed;
        bottom: -45px;
        left: 0.5cm;
        right: 0.5cm;
        background-color: #EBEBEB;
        color: #000;
        padding: 10px 10px;
        text-align: center;
        font-size: 9px;
    }

    /* #footer-subtotal {
        position: fixed;
        bottom: -154px;
        left: 0.5cm;
        right: 0.5cm;
    } */
    .table {
        font-size: 12px;
    }

    td,
    th {
        padding: 3px !important;
    }

    th {
        background-color: #EBEBEB;
    }

    .title {
        font-weight: bold;
        font-size: 19px;
        margin: 0px;
    }

    .description {
        font-size: 12px;
    }

    .card {
        border: 1px solid #c3c3c3;
        border-radius: 5px;
        padding: 5px;
    }

    .company_description {
        font-size: 12px;
    }

    .company_description p {
        margin: 0px;
    }

    .padding-content {
        margin-top: 10px;
    }
</style>

<div class="row" style="width: 92%;">
    <div class="col-xs-2">
        <img height="70" src="{{public_path('img/aguas_chile.PNG')}}" alt="">
    </div>
    <div class="col-xs-10">
        <div class="card">
            <h3 class="title">AGUA PURIFICADA</h3>
            <div class="company_description">
                <p>Rut: </p>
                <p>Dirección: </p>
                <p>Teléfono: </p>
                <p>Correo: </p>
            </div>
        </div>
    </div>
</div>

<div class="padding-content">
    <h3 class="title">Detalles de la venta #{{ $data['venta_id'] }}</h3>
    <table class="table">
        <tr>
            <th>Cliente</th>
            <th>Identificación</th>
            <th>Edificio</th>
            <th>Dirección edificio</th>
        </tr>
        <tr>
            <td>{{ $data['cliente_nombres'] }} {{ $data['cliente_apellidos'] }}</td>
            <td>{{ $data['identificacion'] }}</td>
            <td>{{ $data['edificio_nombre'] }}</td>
            <td>{{ $data['edificio_direccion'] }}</td>
        </tr>
        <tr>
            <th>Producto</th>
            <th>Modulo</th>
            <th>Cantidad de bidones</th>
            <th>Contraseña modulo</th>
        </tr>
        <tr>
            <td>{{ $data['producto'] }}</td>
            <td>{{ $data['modulo_nombre'] }}</td>
            <td>{{ $data['cantidad_bidones_venta'] }}</td>
            <td>{{ $data['modulo_contrasena'] }}</td>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>Total venta</th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $data['valor_venta'] }}</td>
        </tr>

    </table>
</div>