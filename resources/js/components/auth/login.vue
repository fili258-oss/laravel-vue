<script setup>
    import axios from 'axios';
    import { reactive, ref } from 'vue';

    let form = reactive({
        email:'',
        password:''
    });

    let error = ref('');

    const login = async() =>{        

        await axios.post('/api/login', form)
            .then(response =>{
                if (response.data.success)
                {
                    console.log(response)
                    localStorage.setItem('token', response.data.data.token)
                }else
                {
                    error.value = response.data.message;
                }
            })
    }

</script>
<template>
<div class="d-flex justify-content-center align-items-center bannerLogin" style="height: 100vh;">
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 rounded-4">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="row">
              <div class="col-12">
                <div class="mb-4">
                  <h3>Iniciar sesión</h3>                  
                </div>
              </div>
            </div>
            <p v-if="error" class="text-danger">{{ error }}</p>
            <form @submit.prevent="login">
              <div class="row overflow-hidden">
                <div class="col-12">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" class="form-control" v-model="form.email" name="email" id="email" placeholder="nombre@ejemplo.com" required>
                    
                </div>
                <div class="col-12">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" v-model="form.password" name="password" id="password" value="" placeholder="Ingrese su contraseña" required>                    
                </div>

                <div class="col-12 mt-3">
                  <div class="d-grid">
                    <button class="btn btn-primary" type="submit">Ingresar</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="row">
              <div class="col-12">
                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">
                  <a href="#!">¿Se te olvidó?</a>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
</template>
<style scoped>
.bannerLogin{
    background: rgb(2,0,36);
    background: linear-gradient(45deg, rgba(2,0,36,1) 0%, rgba(3,45,89,1) 14%, rgba(0,212,255,1) 100%);
}

</style>