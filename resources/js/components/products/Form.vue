<template>
    <section>
        <form class="row g-3 mt-4">
            <div class="col-md-6">
                <label for="nameProduct" class="form-label">Nombre del producto</label>
                <input type="text" class="form-control" id="nameProduct">
            </div>
            <div class="col-6">
                <label for="inputAddress2" class="form-label">Precio</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">Categoría</label>
                <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="col-md-6">
                <label for="inputState" class="form-label">Inventario</label>
                <input type="number" class="form-control" placeholder="Ej:15">
            </div>
            <div class="col-md-12">
                <label for="inputPassword4" class="form-label">Descripción del producto</label>
                <textarea name="descriptionProduct" class="form-control" id="descriptionProduct" placeholder="Agrega tu descripción"></textarea>
            </div>
            <div class="col-12">
                <label for="formFileMultiple" class="form-label">Fotografías</label>
                <input class="form-control" type="file" id="formFileMultiple" multiple>
            </div>            
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </section>
</template>