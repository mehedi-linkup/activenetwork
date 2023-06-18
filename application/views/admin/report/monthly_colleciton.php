<style>
    .cart {
        padding: 25px;
        text-align: center;
        border: 1px solid #00897b;
        background: #00897b;
        color: #fff;
        border-radius: 5px;
    }
    .cart strong {
        font-size: 25px;
    }
</style>
<div class="widget-box" id="app">
    <div class="widget-header">
        <h4 class="widget-title">Monthly Collection</h4>
        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="ace-icon fa fa-chevron-up"></i>
            </a>

            <a href="#" data-action="close">
                <i class="ace-icon fa fa-times"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div class="widget-main">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <form @submit.prevent="getCollection">
                            <div class="form-group">
                                <label for="fromdate" class="col-md-1 col-md-offset-1">From</label>
                                <div class="col-md-3" style="padding:0px">
                                    <input type="date" class="form-control" v-model="filter.dateFrom" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fromdate" class="col-md-1">To</label>
                                <div class="col-md-3" style="padding:0px">
                                    <input type="date" class="form-control" v-model="filter.dateTo" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <input type="submit" class="btn btn-sm btn-block btn-info" value="Search">
                                </div>
                            </div>
                        </form>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-5 col-md-offset-1">
                            <div class="cart">
                                <strong>
                                    <i class="">&#2547;</i> &nbsp;
                                </strong>
                                <strong>
                                    {{ dishTotal }}
                                </strong>
                                <br>
                                <h3>Dish Collection Total</h3>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="cart">
                                <strong>
                                    <i class="">&#2547;</i> &nbsp;
                                </strong>
                                <strong>
                                    {{ wifiTotal }}
                                </strong>
                                <br>
                                <h3>Wifi Collection Total</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/backend/js/vue.js')?>"></script>
<script src="<?php echo base_url('assets/backend/js/axios.js')?>"></script>

<script>
    const app = new Vue({
        el: '#app',
        data: {
            filter: {
                dateFrom: new Date().toISOString().substr(0, 10),
                dateTo: new Date().toISOString().substr(0, 10),
            },
            dishTotal: 0.00,
            wifiTotal: 0.00 
        },
        methods: {
            async getCollection() {
                await axios.post('/get-monthly-collection', this.filter)
                .then(res => {
                    this.dishTotal = res.data.dish;
                    this.wifiTotal = res.data.wifi;
                })
            }
        }
    })
</script>