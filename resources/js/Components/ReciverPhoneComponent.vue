<template>
        <div class="card">
        <div class="card-header text-primary">
            <h2>{{ heading }} </h2>
        </div>
        <form @submit="changetel">
        <div class="card-body">
        <div v-if="message.length">
             <div class="alert alert-success">
               {{ message }}
             </div>
        </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" v-model="optionTel" id="customSwitchTel">
                    <label class="custom-control-label" for="customSwitchTel">Want to change tel No.</label>
                </div>
            </div>

            <div v-if="optionTel">
                <input type="text" v-model="reciver_tel" class="form-control" >
            </div>
            <div v-else>
                 <input type="text" v-model="reciver_tel" class="form-control disabled" disabled>
            </div>
        </div>
        <div class="card-footer">
             <div v-if="optionTel">
                <button class="btn btn-success btn-sm float-right" >Change</button>
            </div>
            <div v-else>
                 <button class="btn btn-success btn-sm float-right"  disabled>Change</button>
            </div>
        </div>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            heading: "Reciver Tel No",
            optionTel: false,
            reciver_tel: '',
            message: '',
        }
    },
    methods: {
        changetel(e) {
            e.preventDefault();
            axios.post('/change-reciver-tel', {
                tel: this.reciver_tel,
                csrf_token: $('meta[name="csrf-token"]').attr('content')
            }).then((resp) => {
                if(resp.data.response == true)
                {
                    this.optionTel = false;
                    this.message = resp.data.message;
                }
            })
        }
    },
    created() {
  	   axios.get('/reciver-tel')
                .then((resp) => {
                   this.reciver_tel = resp.data;
                })
    },
}
</script>
