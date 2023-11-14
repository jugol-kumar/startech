<template>
    <CustomerLayout>

        <div class="d-flex gap-1 mb-2">
            <a href="/dashboard" class="back-btn">
                <vue-feather type="arrow-left"/>
            </a>
            <h2 class="fw-semibold text-primary">Order History</h2>
        </div>


        <div class="row m-0 p-0">

            <div class="col-md-12" v-if="props.orders.data.length > 0">
                <div class="card page-shadow" v-for="item in props.orders.data" :key="item.id">
                    <div class="card-header border-b">
                        <div>
                            <h3>Order #{{ item.id }}</h3>
                            <span>Order Date: {{ $formattedTime(item.created_at) }}</span>
                        </div>
                        <div class="d-flex gap-1 ">
                            <span class="text-success">
                                <vue-feather type="check-circle"/>
                            </span>
                            <p class="m-0 text-success text-capitalize">{{ item.order_status }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="order-image">
                                    <img class="w-100 h-100" :src="item?.order_details[0]?.product.thumbnail" alt="">
                                </div>
                                <div>
                                    <p class="text-black fw-semibold mt-2">{{ item?.order_details[0]?.product.title }}</p>
                                    <small class="fw-semibold text-black" v-if="item?.order_details.length > 1"> + {{ item?.order_details.length - 1 }} item(s) </small>
                                </div>
                            </div>

                            <div class="d-flex gap-2 align-items-center">
                                <h3>{{ item?.grand_total }} ৳</h3>
                                <a :href="`/single-order/${item.id}`" class="btn btn-primary">View</a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <Pagination :links="orders.links" :from="orders.from" :to="orders.to" :total="orders.total"/>
                    </div>
                </div>
            </div>

            <p class="text-black fs-4 fw-semibold" v-else>
                No have any order yet
            </p>
        </div>
<!--                <table class="table table-striped table-borderless table-responsive">
                    <thead>
                    <th class="p-1">OrderId</th>
                    <th class="p-1">Total Price</th>
                    <th class="p-1">Payment Method</th>
                    <th class="p-1">Payment Status</th>
                    <th class="p-1">Order Status</th>
                    </thead>

                    <tbody>
                    <tr>
                        <td>#laravel_{{ item.id }}</td>
                        <td>{{ $showPrice(item.cart_total_price) }}</td>
                        <td>{{ item.payment_method }}</td>
                        <td>
                        <span class="badge bg-light-primary">
                            {{ item.payment_status }}
                        </span>
                        </td>
                        <td>
                        <span class="badge bg-light-primary">
                            {{ item.order_status }}
                        </span>
                        </td>
                    </tr>
                    </tbody>
                </table>-->

    </CustomerLayout>
</template>
<script setup>
import CustomerLayout from "./Layout.vue";
import Pagination from "../../../components/Pagination";


const props = defineProps({
    orders:Object,
})


</script>
<style scoped>
.order-image{
    max-width:110px;
}
.border-b{
    border-bottom:1px solid #f2f4f8;
}
</style>
