
<script setup>
import {computed, onMounted, ref, watch} from "vue";
import Modal from "../../../components/Modal.vue";
import Gallery from "../Modules/Gallery.vue";
import {useWishListStore} from "../../../Store/useWishListStore.js";
import {useCartStore} from "../../../Store/useCartStore";
import {useData} from "../../../Composables/useData";
import debounce from "lodash/debounce";
import {Inertia} from "@inertiajs/inertia";

const store = useCartStore();
const watchlistStore = useWishListStore();
const data = useData();
const showProductDetails =()=>document.getElementById(props.product.slug).$vb.modal.show()


    onMounted(() =>{
        store.initCart();
        watchlistStore.initWishList();
    })
    const props = defineProps({
        product:Object|null,
        color:Object|null,
        discountData:[]|null,
    })

    const currentSlide = ref(null)
    const sizeRadio = ref(false)
    const breakpoints = {
        700: {
            itemsToShow: 3,
            snapAlign: 'end',
        },
        1024: {
            itemsToShow: 5,
            snapAlign: 'start'
        }
    }

    const images = computed(() =>{
        let images = [];
        for (let i = 0; i< JSON.parse(props.product.images).length; i++){
            images.push("/storage/"+JSON.parse(props.product.images)[i])
        }
        images.push(props.product.thumbnail)
        return images;
    })

    // const discountPrice = computed(()=>{
    //     if (props.discountData?.discount_price && props.discountData?.discount_type){
    //         return data.discountPrice(props.product.price, props.discountData.discount_price, props.discountData.discount_type);
    //     }else{
    //         return false;
    //     }
    // })

    const cartSize = ref(null);
    const selectSize = (event) => cartSize.value = event.target.value;


    const addToCart = () => {
        let sellPrice = props.product.discount ?? props.product.price;
        store.addToCart({...props.product, price:sellPrice, quantity:1})
    }

    const isInCart = computed(() =>{
        return store.cart.find(item => item.id === props.product.id)?.quantity
    })

    const addToWishList = (product) =>{
        if (discountPrice.value){
            if(cartSize.value !== null){
                watchlistStore.addToWishList({...product, quantity:1, size:cartSize, sellPrice:discountPrice.value})
            }else{
                $toast.warning("Please chose first your needed size...")
            }
        }else{
            if(cartSize.value !== null){
                watchlistStore.addToWishList({...product, quantity:1, size:cartSize, sellPrice:product.price })
            }else{
                $toast.warning("Please chose first your needed size...")
            }
        }
    }


</script>


<template>
    <div class="card offer border-0 single-product-card">
        <a :href="`${$page.props.auth.MAIN_URL}/product/single-product/${props.product.slug}`">
            <img class="card-img-top w-100 star-pro-img" :src="props.product.thumbnail" alt="">
        </a>
        <div class="card-body" @click="showProductDetails">
            <div class="card-product-details card-text d-flex flex-column text-left">
                <h5 class="text-black text-capitalize product-title">
                    <a class="d-md-none d-block" :href="`${$page.props.auth.MAIN_URL}/product/single-product/${props.product.slug}`">
                        {{ props.product?.title.length > 20 ? props.product?.title?.slice(0, 20) : props.product?.title }}...
                    </a>

                    <a class="d-none d-lg-block" :href="`${$page.props.auth.MAIN_URL}/product/single-product/${props.product.slug}`">
                        {{ props.product?.title.length > 50 ? props.product?.title?.slice(0, 50) : props.product?.title }}...
                    </a>
                </h5>
            </div>
        </div>
        <div class="card-footer px-2 border-0">
            <div class="d-flex justify-content-between gap-2">
                <h4 class="fw-bold text-danger product-price">{{ $showPrice(product.discount ? product.discount : product.price) }}</h4>
                <s class="fs-5 product-price" v-if="product.discount">{{ $showPrice(product.price) }}</s>
            </div>
        </div>
    </div>

<!--

    <Modal :id="props.product.slug" title="" v-vb-is:modal size="lg">
        <div class="row mx-2 mb-3">
            <div class="col-12 col-md-5">
                <div class="row flex-column">
                    <img :src="props.product.thumbnail" alt="">
                </div>
            </div>
            <div class="col-12 col-md-7">
                <p class="text-capitalize text-black fs-4 p-0 modal-product-title text-center" v-text="product.title"></p>

                <p class="text-capitalize text-black-50 fs-4 p-0 modal-product-title text-center">{{ product.unit }}</p>

                <div class="ecommerce-details-price d-flex flex-wrap mt-1 align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <h2>{{ $showPrice(product.discount ? product.discount : product.price) }}</h2>
                        <s class="fs-5" v-if="product.discount">{{ $showPrice(product.price) }}</s>
                    </div>
                    <div>
                        <div class="p-1 bg-primary text-white discount-price-show" v-if="product.discount">{{ $showPrice(product.price - product.discount) }} Off</div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row pt-1">
                    <button v-if="isInCart === undefined" @click="addToCart(product)"  class="btn btn-primary btn-cart me-0 me-sm-1 mb-1 mb-sm-0 d-flex align-items-center">
                        <vue-feather type="shopping-cart" class="me-50"/>
                        <span class="add-to-cart text-white">{{"Add to cart"}}</span>
                    </button>
                    <button v-else @click="store.incrementQty(product.id)"
                            :disabled="isInCart === product.qty"
                            class="btn btn-primary btn-cart me-0 me-sm-1 mb-1 mb-sm-0 d-flex align-items-center">
                        <vue-feather type="shopping-cart" class="me-50"/>
                        <span class="add-to-cart">{{ isInCart+" Item In Cart" }}</span>
                    </button>
                </div>
                <p class="card-text mt-3 product-spesificaiton" v-html="product.specification"></p>
            </div>
        </div>
    </Modal>
-->

</template>
<style scoped>
.offer {
    box-shadow: 0 1px 1px rgba(0,0,0,.1) !important;
}
.offer .card-body{
    border-top: 5px solid #f4faff;
}
.card-product-details h5 a:hover{
    color:red;
    text-decoration:underline;
}
</style>
