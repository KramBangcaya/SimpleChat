<template>
    <div class="modal fade" id="add-program">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <alert-error :form="form"></alert-error>
                    <div class="form-group">
                        <label>Name</label>
                        <input v-model="form.name" type="text" class="form-control">
                        <has-error :form="form" field="name"/>
                    </div>
                    <div class="form-group">
                        <label>Code</label>
                        <input v-model="form.code" type="text" class="form-control">
                        <has-error :form="form" field="code"/>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input v-model="form.email" type="email" class="form-control">
                        <has-error :form="form" field="email"/>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <input v-model="form.category" type="text" class="form-control">
                        <has-error :form="form" field="category"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="create">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
    export default {
        components: {
            Multiselect
        },
        data(){
            return{
                form: new Form({
                    name:'',
                    code:'',
                    email:'',
                    category:'',
                }),
            }
        },
        methods: {
            create(){
                this.form.post('/api/program/create').then(()=>{
                    toast.fire({
                        icon: 'success',
                        text: 'Data Saved.',
                    })
                    this.form.reset();
                    this.$emit('getData');
                    // $('#add-program').modal('hide');
                }).catch(()=>{
                    toast.fire({
                        icon: 'error',
                        text: 'Something went wrong!',
                    })
                });
            },
        },
        mounted() {
        }
    }
</script>

