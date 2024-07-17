<script setup>
import axios from 'axios';
import { reactive } from 'vue';

    const form = reactive({
        name: "",
        description: "",
        image: "",
        type: 0,
        quantity: "",
        price: ""
    })

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
        e.preventDefault();
        axios.post('/api/products', form)
    }

    const handleSaveSuccess = () => {
        alert("Registro guardado exitosamente!")
    }
</script>
<template>
    <section>
        <form class="row g-3 mt-4">
            <div class="col-md-6">
                <label for="nameProduct" class="form-label">Nombre del producto</label>
                <input type="text" v-model="form.name" class="form-control" id="nameProduct">
            </div>
            <div class="col-6">
                <label for="priceProduct" class="form-label">Precio</label>
                <input type="number" v-model="form.price" class="form-control" id="priceProduct" placeholder="Ej:200000">
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
                <input type="number" v-model="form.inventary" class="form-control" placeholder="Ej:15">
            </div>
            <div class="col-md-12">
                <label for="inputPassword4" class="form-label">Descripción del producto</label>
                <textarea v-model="form.description" name="descriptionProduct" class="form-control" id="descriptionProduct" placeholder="Agrega tu descripción"></textarea>
            </div>
            <div class="col-12">
                <label for="formFileMultiple" class="form-label">Fotografías</label>                
                <input type="file" @change="handleFileChange" class="form-control" multiple>
                <img :src="getImage()" alt="Imagen de producto" class="img-thumbnail mt-2" width="100">
            </div>            
            
            <div class="col-12">
                <button @click="handleSave" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </section>
</template>