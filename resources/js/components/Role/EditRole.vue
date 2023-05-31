<template>
    <div class="modal fade" id="edit-user">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Permission</h5>
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
                <button type="button" class="btn btn-primary" @click="update">Save changes</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            row: {required: true},
            page: {required: true},
        },
        data(){
            return{
                form: new Form({
                    id:'',
                    name:'',
                    guard_name:'',
                    permissions:null,
                }),
                option_permissions:[],
            }
        },
        methods: {
            update(){
                this.form.put('api/role/update/'+this.form.id).then(()=>{
                    toast.fire({
                        icon: 'success',
                        text: 'Data Saved.',
                    })
                    //"page" maintain selected page in the parent page
                    this.$emit('getData', this.page);// call method from parent (reload data table)
                    $('#edit-user').modal('hide');
                }).catch(error =>{
                    toast.fire({
                        icon: 'error',
                        text: error.message,
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
        watch: {
            row: function(){
                this.form.reset();
                this.form.fill(this.row);
            }
        },
        mounted() {
            this.loadPermission();
        }
    }
</script>
