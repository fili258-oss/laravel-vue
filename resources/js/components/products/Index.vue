<script setup>
    import axios from "axios";
    import { onMounted, ref, reactive } from "vue";        

    let products = ref([])

    onMounted(async () => {
        getProducts()
    })
    const newProduct = () => {                
        cleanForm();
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
        isLoading:false,
        actionForm:false,
        idProduct:'',
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
        form.isLoading = true;
        if (form.actionForm)
        {
            updateProduct();
        }else
        {
            createProduct();
        }
        
    }
    
    const createProduct = () => {        
        axios.post('/api/products', form)
        .then((response) => {                                   
            if(response)
            {
                form.isLoading = false;
                $("#createProductModal").modal('hide');
                toast.fire({ icon:"success", title:"Producto creado éxitosamente"})
                getProducts()                                
            }
            

        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors
                form.isLoading = false;
            }
        })
    }

    /* Código para editar un producto */
    const handleEdit = (idProduct) => {
        errors.value = '';       
        form.idProduct = idProduct;
        form.actionForm = true;        
        getProduct();
        
    }

    const getProduct = async () =>{

        let response = await axios.get(`/api/products/${form.idProduct}/edit`)
        .then((response) =>{
            if (response) {
                form.name = response.data.product.name
                form.description = response.data.product.description
                form.image = response.data.product.image
                form.type = response.data.product.type
                form.quantity = response.data.product.quantity
                form.price = response.data.product.price
                $("#createProductModal").modal('show');
            }
        })
    }

    const updateProduct = async () =>{
        axios.put(`/api/products/${form.idProduct}`, form)
        .then((response) => {                                   
            if(response)
            {
                form.isLoading = false;
                $("#createProductModal").modal('hide');
                toast.fire({ icon:"success", title:"Producto actualizado éxitosamente"})
                getProducts()                                
            }
            

        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors
                form.isLoading = false;
            }
        })
    }

    const cleanForm = () =>{

        errors.value = '';
        form.isLoading = false;
        form.actionForm = false;
        form.idProduct = '';
        form.name = '';
        form.description = '';
        form.image = '';
        form.type = 0;
        form.quantity = '';
        form.price = '';
    }

    /* Código para eliminar un producto */
    const handleDelete = (idProduct) =>{
        errors.value = '';       
        form.idProduct = idProduct;
        form.actionForm = false;

        Swal.fire({
        title: "¿Estas seguro?",
        text: "Ya no podrás revertir esta acción!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, bórralo!",
        cancelButtonText: "Cancelar",
        }).then((result) => {
        if (result.isConfirmed) {
            destroyProduct();            
        }
        });
    }

    const destroyProduct = async () =>{
        axios.delete(`/api/products/${form.idProduct}/delete`)
        .then((response) => {                                   
            if(response)
            {                                
                toast.fire({ icon:"success", title:"Producto eliminado éxitosamente"})
                getProducts()                                
            }
            

        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors
                form.isLoading = false;
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
                    <button @click="handleEdit(product.id)" type="button" class="btn btn-sm btn-outline-primary activeDT">Editar</button>&nbsp;
                    <button @click="handleDelete(product.id)" type="button" class="btn btn-sm btn-outline-danger">Eliminar</button>        
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
            <h5 v-if="form.actionForm" class="modal-title" id="exampleModalLabel">Editar producto</h5>
            <h5 v-else="form.actionForm" class="modal-title" id="exampleModalLabel">Crear producto</h5>
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
            <!--<button @click="handleSave" class="btn btn-primary">Guardar</button>-->
            <button @click="handleSave" :disabled="form.isLoading" type="submit" class="btn btn-primary" >
                <span v-if="form.isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span v-if="form.isLoading"> Guardando...</span>
                <span v-else>Guardar </span>                        
          </button>
        </div>
        </div>
    </div>
    </div>

</template>