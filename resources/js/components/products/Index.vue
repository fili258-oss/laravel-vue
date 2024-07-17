<script setup>
    import axios from "axios";
    import { onMounted, ref, reactive } from "vue";
    import { useRouter } from "vue-router";

    const router = useRouter()

    let products = ref([])

    onMounted(async () => {
        getProducts()
    })
    const newProduct = () => {
        $("#createProductModal").modal('show');
        console.log("Crear producto...")
        //router.push('/products/create')

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
    /* Codigo para guardar un producto */
    const form = reactive({
        name: "",
        description: "",
        image: "",
        type: 0,
        quantity: "",
        price: ""
    })
    
    const errors = ref([])
    const getImage = () => {
        let image = "/upload/no-picture.png"
        if (form.image) {
            if (form.image.indexOf("base64") != -1) {
                image = form.image
            }else
            {
                image = "/upload/" + form.image
            }
        }
        return image
    }

    const handleFileChange = (e) => {
        let file = e.target.files[0]
        let reader = new FileReader()
        reader.onloadend = (file) => {
            form.image = reader.result
        }
        reader.readAsDataURL(file)

    }
    const handleSave = () => {        
        axios.post('/api/products', form)
        .then((response) => {                                   
            getProducts()
            toast.fire({ icon:"success", title:"Producto creado éxitosamente"})
            

        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors
            }
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
            <button @click="newProduct" type="button" class="btn btn-primary">Crear nuevo</button>
            <div class="btn-group ml-2" role="group" aria-label="Basic example">                
                <select name="selectProducts" id="selectProducts" class="form-select">
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
                    <div><img :src="ourImage(product.image)" alt="Imagen de producto" class="img-thumbnail mt-2" width="55"></div>
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
    <!-- Modal -->
    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear un producto nuevo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="nameProduct" class="form-label">Nombre del producto</label>
                    <input type="text" v-model="form.name" class="form-control" id="nameProduct">
                    <small class="text-danger" v-if="errors.name">{{ errors.name }}</small>
                </div>
                <div class="col-6">
                    <label for="priceProduct" class="form-label">Precio</label>
                    <input type="number" v-model="form.price" class="form-control" id="priceProduct" placeholder="Ej:200000">
                    <small class="text-danger" v-if="errors.price">{{ errors.price }}</small>
                </div>
                <div class="col-md-6">
                    <label for="categoryProduct" class="form-label">Categoría</label>
                    <select v-model="form.type" class="form-select" name="categoryProduct" id="categoryProduct">
                        <option value="0">Seleccione una opción</option>
                        <option value="1">Aseo y jabón</option>
                        <option value="2">Canasta Familiar</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="inputState" class="form-label">Inventario</label>
                    <input type="number" v-model="form.quantity" class="form-control" placeholder="Ej:15">
                    <small class="text-danger" v-if="errors.quantity">{{ errors.quantity }}</small>
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Descripción del producto</label>
                    <textarea v-model="form.description" name="descriptionProduct" class="form-control" id="descriptionProduct" placeholder="Agrega tu descripción"></textarea>
                    <small class="text-danger" v-if="errors.description">{{ errors.description }}</small>
                </div>
                <div class="col-12">
                    <label for="formFileMultiple" class="form-label">Fotografías</label>                
                    <input type="file" @change="handleFileChange" class="form-control" multiple>
                    <img :src="getImage()" alt="Imagen de producto" class="img-thumbnail mt-2" width="100">
                </div>
            </div>                                                

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button @click="handleSave" class="btn btn-primary">Guardar</button>
        </div>
        </div>
    </div>
    </div>

</template>