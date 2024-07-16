<script setup>
    import { useRouter } from "vue-router";

    const router = useRouter()
    const newProduct = () => {
        router.push('/products/create')

    }
</script>
<template>
    <div>
        <h1>Listado de productos</h1>
    </div>
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="form-group">
                
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nombre del producto">
            </div>
        </div>
        <div class="col-lg-6 text-end">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button @click="newProduct" type="button" class="btn btn-primary">Crear nuevo</button>
                <select name="selectProducts" id="selectProducts">
                    <option value="1">Activos</option>
                    <option value="2">Desactivos</option>
                </select>                
            </div>
        </div>
    </div>
    <table class="table table-striped">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Handle</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
        </tr>
        <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
        </tr>
        <tr>
        <th scope="row">3</th>
        <td>Larry</td>
        <td>the Bird</td>
        <td>@twitter</td>
        </tr>
    </tbody>
    </table>
</template>