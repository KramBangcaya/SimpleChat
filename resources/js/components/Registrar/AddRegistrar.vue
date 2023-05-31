<template>
    <div class="modal fade" id="add-user">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Registrar</h5>
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
                        <label>First Name</label>
                        <input v-model="form.first_name" type="text" class="form-control">
                        <has-error :form="form" field="first_name"/>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input v-model="form.last_name" type="text" class="form-control">
                        <has-error :form="form" field="last_name"/>
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input v-model="form.middle_name" type="text" class="form-control">
                        <has-error :form="form" field="middle_name"/>
                    </div>
                    <div class="form-group">
                        <label>Extension Name</label>
                        <input v-model="form.extension_name" type="text" class="form-control">
                        <has-error :form="form" field="extension_name"/>
                    </div>
                    <div class="form-group">
                        <label>Program ID</label>
                        <input v-model="form.program_id" type="text" class="form-control">
                        <has-error :form="form" field="program_id"/>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select v-model="form.category" class="form-control">
                            <option value="c">College</option>
                            <option value="shs">Senior High School</option>
                            <option value="gs">Graduate School</option>
                        </select>
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
                    first_name:'',
                    last_name:'',
                    middle_name:'',
                    extension_name:'',
                    program_id:'',
                    category:'',
                }),
                option_permissions:[],
            }
        },
        methods: {
            create(){
                this.form.post('/api/registrar/create').then(()=>{
                    toast.fire({
                        icon: 'success',
                        text: 'Data Saved.',
                    })
                    this.form.reset();
                    this.$emit('getData');
                    $('#add-user').modal('hide');
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

