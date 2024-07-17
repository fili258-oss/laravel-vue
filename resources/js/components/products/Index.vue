<script setup>
    import axios from "axios";
    import { onMounted, ref } from "vue";
    import { useRouter } from "vue-router";
    ref

    const router = useRouter()

    let products = ref([])

    onMounted(async () => {
        getProducts()
    })
    const newProduct = () => {
        router.push('/products/create')

    }

    const ourImage = (img) => {
        return "/upload/"+img
    }

    const getProducts = async () => {
        let response = await axios.get ('/api/products')
        .then((response) => {
            destruirTable("tableProducts");
            products.value = response.data.products
            inicia_tabla("tableProducts");
            
        })
        
    }

</script>
<template>
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="form-group">                
                <h1>Listado de productos</h1>
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
    <div class="table-responsive mt-4">
        <table id="tableProducts" class="table table-striped table-sm">
            <thead>
            <tr>
                <td>
                    <div>Imagen</div>
                </td>
                <td>
                    <div>Nombre</div>
                </td>
                <td>
                    <div>Precio</div>
                </td>
                <td>
                    <div>Cantidad</div>
                </td>
                <td>
                    <div>Categoría</div>
                </td>
                <td>
                    <div>Acciones</div>
                </td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products" :key="product.id">
                <td>
                    <div><img :src="ourImage(product.image)" alt="Imagen de producto" class="img-thumbnail mt-2" width="100"></div>
                </td>
                <td>
                    <div>{{product.name}}</div>
                </td>
                <td>
                    <div>{{product.price}}</div>
                </td>
                <td>
                    <div>{{product.quantity}}</div>
                </td>
                <td>
                    <div>{{product.type}}</div>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-primary activeDT">Editar</button>        
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</template>