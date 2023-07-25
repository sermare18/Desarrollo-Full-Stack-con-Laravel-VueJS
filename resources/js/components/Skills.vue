<template>
    <div class="container">
        <div class="card">
            <div class="card-header">Skills</div>
            <div class="card-body">
                <div v-for="(input, i) in inputs" v-bind:key="i" class="d-flex mb-2 p-0">
                    <div class="col-md-10 me-4">
                        <input 
                            placeholder="Javascript" 
                            class="form-control" 
                            type="text" 
                            name="skills[]"
                            v-model="inputs[i]">
                    </div>
                    <div class="col-md-2 me-2">
                        <button class="btn btn-danger" @click.prevent="remove(i)">
                            Delete
                        </button>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary" @click.prevent="add()">
                        Add
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    // props son las propiedades del componente vue
    props: {
        skills: {
            type: Array,
            // Por defecto, devuelve una lista vacía
            default: () => ([]),
        },

        errors: {
            type: Array,
            default: () => []
        }
    },

    mounted() {
        console.log('Component mounted.')
    },

    // la función data se utiliza para definir las propiedades reactivas del componente. (Se ejecuta al montarse el objeto automáticamente)
    data() {
        return {
            inputs: this.skills,
        }
    },

    // methods se utiliza para definir los métodos de un componente vue
    methods: {
        add() {
            this.inputs.push('');
        },

        remove(i) {
            this.inputs.splice(i, 1);
        }
    }
}
</script>
