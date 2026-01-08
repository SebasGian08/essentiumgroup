<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Guía de Pedido {{ $pedido->codigo_pedido }}</title>
    <style>
        /* Tipografía moderna */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #ffffffff;
            margin: 0;
            padding: 20px;
        }

        /* Título */
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        /* Información del pedido */
        .info-pedido p {
            margin: 5px 0;
            line-height: 1.5;
            font-size: 14px;
        }

        .info-pedido strong {
            color: #34495e;
        }

        /* Tabla de productos */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Totales */
        .total {
            text-align: right;
            margin-top: 15px;
            font-size: 16px;
            font-weight: bold;
            color: #e74c3c;
        }

        /* Encabezados de sección */
        h3 {
            margin-top: 25px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Guía de Pedido: {{ $pedido->codigo_pedido }}</h2>

        <div class="info-pedido">
            <p><strong>Cliente:</strong> {{ $pedido->nombre_cliente }}</p>
            <p><strong>Teléfono:</strong> {{ $pedido->telefono_cliente }}</p>
            <p><strong>Dirección:</strong> {{ $pedido->direccion_envio }}, {{ $pedido->distrito }}, {{ $pedido->provincia }}, {{ $pedido->departamento }}</p>
            <p><strong>Fecha de Entrega:</strong> {{ $pedido->fecha_entrega }}</p>
        </div>

        <h3>Productos</h3>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detalles as $d)
                <tr>
                    <td>{{ $d->codigo_producto }}</td>
                    <td style="text-align:left">{{ $d->descripcion }}</td>
                    <td>{{ $d->cantidad }}</td>
                    <td>S/ {{ number_format($d->precio_unitario,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Total: S/ {{ number_format($pedido->total,2) }}</p>
    </div>
</body>
</html>
