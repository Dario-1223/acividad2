<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Categorías</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f7f7f7;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 500px;
            margin: 0 auto 30px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        input[type="text"], textarea {
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            padding: 10px 15px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #2980b9;
        }

        .btn-cancelar {
            background: #e74c3c;
        }

        .btn-cancelar:hover {
            background: #c0392b;
        }

        table {
            margin: auto;
            border-collapse: collapse;
            width: 80%;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .acciones {
            display: flex;
            gap: 5px;
            justify-content: center;
        }

        .mensaje {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }

        .exito {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <h1>Gestión de Categorías</h1>

    <form id="formCategoria">
        <input type="hidden" id="id_categoria">
        <input type="text" id="nombre" placeholder="Nombre de la categoría" required>
        <textarea id="descripcion" placeholder="Descripción de la categoría" required></textarea>
        <div class="acciones">
            <button type="submit" id="btnGuardar">Guardar</button>
            <button type="button" id="btnCancelar" class="btn-cancelar" style="display: none;">Cancelar</button>
        </div>
    </form>

    <div id="mensaje" class="mensaje" style="display: none;"></div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tablaCategorias"></tbody>
    </table>

    <script>
        const tabla = document.getElementById('tablaCategorias');
        const form = document.getElementById('formCategoria');
        const btnGuardar = document.getElementById('btnGuardar');
        const btnCancelar = document.getElementById('btnCancelar');
        const mensaje = document.getElementById('mensaje');

        // Mostrar mensaje
        function mostrarMensaje(texto, tipo) {
            mensaje.textContent = texto;
            mensaje.className = `mensaje ${tipo}`;
            mensaje.style.display = 'block';
            setTimeout(() => {
                mensaje.style.display = 'none';
            }, 3000);
        }

        // Listar categorías
        async function listarCategorias() {
            try {
                const res = await fetch('http://localhost/actividad2/public/api/categorias');
                
                if (!res.ok) {
                    throw new Error('Error al obtener categorías');
                }
                
                const categorias = await res.json();
                tabla.innerHTML = '';

                categorias.forEach(c => {
                    tabla.innerHTML += `
                        <tr>
                            <td>${c.nombre}</td>
                            <td>${c.descripcion || '-'}</td>
                            <td class="acciones">
                                <button onclick="editarCategoria(${c.id_categoria})">Editar</button>
                                <button onclick="eliminarCategoria(${c.id_categoria})">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
            } catch (error) {
                console.error('Error al listar categorías:', error);
                mostrarMensaje('Error al cargar las categorías', 'error');
            }
        }

        // Crear o actualizar categoría
        async function crearOActualizarCategoria(e) {
            e.preventDefault();
            
            const id = document.getElementById('id_categoria').value;
            const nombre = document.getElementById('nombre').value.trim();
            const descripcion = document.getElementById('descripcion').value.trim();

            if (!nombre || !descripcion) {
                mostrarMensaje('Todos los campos son requeridos', 'error');
                return;
            }

            const data = {
                nombre,
                descripcion
            };

            let url = 'http://localhost/actividad2/public/api/categorias';
            let method = 'POST';

            if (id) {
                url = `http://localhost/actividad2/public/api/categorias/${id}`;
                method = 'PUT';
            }

            try {
                const res = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const resultado = await res.json();

                if (!res.ok) {
                    throw new Error(resultado.message || 'Error al guardar categoría');
                }

                mostrarMensaje(id ? 'Categoría actualizada correctamente' : 'Categoría creada correctamente', 'exito');
                form.reset();
                document.getElementById('id_categoria').value = '';
                btnCancelar.style.display = 'none';
                listarCategorias();
            } catch (error) {
                console.error('Error:', error);
                mostrarMensaje(error.message || 'Error al guardar la categoría', 'error');
            }
        }

        // Editar categoría
        async function editarCategoria(id) {
            try {
                const res = await fetch(`http://localhost/actividad2/public/api/categorias/${id}`);
                
                if (!res.ok) {
                    throw new Error('Error al obtener la categoría');
                }
                
                const categoria = await res.json();
                document.getElementById('id_categoria').value = categoria.id_categoria;
                document.getElementById('nombre').value = categoria.nombre;
                document.getElementById('descripcion').value = categoria.descripcion;
                btnCancelar.style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } catch (error) {
                console.error('Error al editar categoría:', error);
                mostrarMensaje('Error al cargar la categoría para editar', 'error');
            }
        }

        // Eliminar categoría
        async function eliminarCategoria(id) {
            if (!confirm('¿Estás seguro de eliminar esta categoría?')) {
                return;
            }

            try {
                const res = await fetch(`http://localhost/actividad2/public/api/categorias/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!res.ok) {
                    throw new Error('Error al eliminar la categoría');
                }

                mostrarMensaje('Categoría eliminada correctamente', 'exito');
                listarCategorias();
            } catch (error) {
                console.error('Error al eliminar categoría:', error);
                mostrarMensaje('Error al eliminar la categoría', 'error');
            }
        }

        // Cancelar edición
        function cancelarEdicion() {
            form.reset();
            document.getElementById('id_categoria').value = '';
            btnCancelar.style.display = 'none';
        }

        // Event listeners
        form.addEventListener('submit', crearOActualizarCategoria);
        btnCancelar.addEventListener('click', cancelarEdicion);

        // Inicializar
        listarCategorias();
    </script>
</body>

</html>