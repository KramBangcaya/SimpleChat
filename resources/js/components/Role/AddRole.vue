<template>
    <div class="modal fade" id="add-user">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Permission</h5>
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
                        <label>Guard Name</label>
                        <input v-model="form.guard_name" type="text" class="form-control">
                        <has-error :form="form" field="guard_name"/>
                    </div>
                    <div class="form-group">
                        <label>Permission</label>
                        <multiselect v-model="form.permissions" :options="option_permissions" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="name" :preselect-first="true">
                        </multiselect>
                        <has-error :form="form" field="guard_name"/>
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
                    guard_name:'api',
                    permissions:null,
                }),
                option_permissions:[],
            }
        },
        methods: {
            create(){
                this.form.post('/api/role/create').then(()=>{
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
            loadPermission(){
                axios.get('/api/permission/all')
                    .then(response => {
                        this.option_permissions = response.data.data;
                });
            }
        },
        mounted() {
            this.loadPermission();
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
