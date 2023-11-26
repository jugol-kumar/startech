<script setup>
import {computed, ref, onMounted} from 'vue'
import Layout from "../Shared/Layout.vue";
import Gallery from "../Modules/Gallery.vue";
import ProductCarousel from "../Modules/ProductCarousel.vue";
import {useCartStore} from "../../../Store/useCartStore";
import {useWishListStore} from "../../../Store/useWishListStore";
import {useData} from "../../../Composables/useData";
import StarTProducts from "../Pages/StarTProducts.vue";
import LightBox from "../../../components/LightBox.vue";

const store = useCartStore();
const watchlistStore = useWishListStore();
const data = useData();

let facebookBtn=null;
let linkedinBtn=null;
let twitterBtn=null;
    onMounted(() =>{
        store.initCart();
        watchlistStore.initWishList();

        // Social Share links.
         facebookBtn= document.getElementById('shareFacebook');
         linkedinBtn= document.getElementById('shareLinkedin');
         twitterBtn= document.getElementById('shareTwitter');

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
        for (let i = 0; i< JSON.parse(props.product?.images)?.length; i++){
            images.push("/storage/"+JSON.parse(props.product?.images)[i])
        }
        images.push(props.product?.thumbnail)
        return images;
    })

    const discountPrice = computed(()=>{
        if (props.discountData?.discount_price && props.discountData?.discount_type){
            return data.discountPrice(props.product?.price, props.discountData.discount_price, props.discountData.discount_type);
        }else{
            return false;
        }
    })

    const initCart = ref(1);
    const increment = () => initCart.value = initCart.value + 1;
    const decrement = () =>{
        if(initCart.value > 1){
            initCart.value = initCart.value - 1;
        }
    }

    // const cartSize = ref(null);
    // const selectSize = (event) => cartSize.value = event.target.value;
    const addToCart = (product) =>{
        // alert(product)
        let sellPrice = product?.discount > 0  ? product?.discount : product?.price;
        store.addToCart({...product, quantity:initCart.value, sellPrice:sellPrice})
        $toast.success("Added to cart successful.")

        // if (discountPrice.value){
        //     store.addToCart({...product, quantity:initCart.value, size:cartSize, sellPrice:discountPrice.value})
        //
        //     // if have product size then start this
        //     // if(cartSize.value !== null){
        //     //     store.addToCart({...product, quantity:1, size:cartSize, sellPrice:discountPrice.value})
        //     // }else{
        //     //     $toast.warning("Please chose first your needed size...")
        //     // }
        // }else{
        // if product size in enable
            // if(cartSize.value !== null){
            // }else{
            //     $toast.warning("Please chose first your needed size...")
            // }
        // }
    }
    const isInCart = computed(() =>{
        return store.cart.find(item => item.id === props.product?.id)?.quantity
    })

    const addToWishList = (product) =>{
        let sellPrice = product?.discount > 0  ? product?.discount : product?.price;
        watchlistStore.addToWishList({...product, quantity:1, sellPrice:sellPrice })

        // if (discountPrice.value){
        //     watchlistStore.addToWishList({...product, quantity:1, sellPrice:discountPrice.value})
        //
        //     // if(cartSize.value !== null){
        //     // }else{
        //     //     $toast.warning("Please chose first your needed size...")
        //     // }
        // }else{
            // if(cartSize.value !== null){
            // }else{
            //     $toast.warning("Please chose first your needed size...")
            // }
        // }

    }


    const shareButton = ref(false)






function shareFacebook() {
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank');
}

function shareTwitter() {
    window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent(`${props.product.title}`), '_blank');
}

function shareLinkedIn() {
    window.open('https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(window.location.href), '_blank');
}

// function shareWhatsApp() {
//     window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent('Check out this product: ' + '{{ $product->name }}') + '%0A' + encodeURIComponent(window.location.href), '_blank');
// }




// posturl posttitle
let postUrl = encodeURI(document.location.href);
let postTitle = encodeURI(props.product?.title);

facebookBtn?.setAttribute("href",`https://www.facebook.com/sharer.php?u=${postUrl}`);
twitterBtn?.setAttribute("href", `https://twitter.com/share?url=${postUrl}&text=${postTitle}`);
linkedinBtn?.setAttribute("href", `https://www.linkedin.com/shareArticle?url=${postUrl}&title=${postTitle}`);




</script>

<template>
    <Layout>
        <head>
            <title>{{ props.product?.title }}</title>
            <meta name="description" :content="props.product?.description" />
            <meta property="og:title" :content="props.product?.title" />
            <meta property="og:description" :content="props.product?.description" />
            <meta property="og:url" :content="this.$page.props.MAIN_URL" />
            <meta property="og:site_name" content="Computer Wala" />
            <meta property="og:image" :content="`${this.$page.props.auth.MAIN_URL}${images[0]}`" />
            <meta property="og:image:width" content="224" />
            <meta property="og:image:height" content="65" />
            <meta name="twitter:card" content="summary_large_image" />
            <meta name="twitter:title" :content="props.product?.title" />
            <meta name="twitter:description" :content="props.product?.description" />
            <meta name="twitter:image" :content="`${this.$page.props.auth.MAIN_URL}${images[0]}`" />
        </head>

        <section class="app-ecommerce-details">
            <div class="card page-shadow position-relative pt-4">
                <!-- Product Details starts -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card single-product-page-header">
                                <div class="py-1 rounded-5 card-body page-shadow d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <p class="p-0 m-0 share">Share: </p>
                                        <ul v-if="shareButton" class="list-group d-flex flex-row gap-1">
                                            <li>
                                                <button class="btn d-flex align-items-center gap-1 btn btn-primary btn-icon rounded-md">
                                                    <vue-feather type="facebook"/>
                                                </button>
                                            </li>
                                            <li>
                                                <button class="btn d-flex align-items-center gap-1 btn btn-primary btn-icon rounded-md">
                                                    <vue-feather type="instagram"/>
                                                </button>
                                            </li>
                                            <li>
                                                <button class="btn d-flex align-items-center gap-1 btn btn-primary btn-icon rounded-md">
                                                    <vue-feather type="twitter"/>
                                                </button>
                                            </li>
                                            <li>
                                                <button class="btn d-flex align-items-center gap-1 btn btn-primary btn-icon rounded-md">
                                                    <vue-feather type="linkedin"/>
                                                </button>
                                            </li>
                                        </ul>
                                        <ul class="list-group d-flex flex-row">
                                            <li class="cursor-pointer" @click="shareFacebook">
                                                    <vue-feather type="facebook"/>
                                            </li>
<!--                                            <li><vue-feather type="instagram"/></li>-->
                                            <li class="cursor-pointer"  @click="shareTwitter">
                                                <vue-feather type="twitter"/>
                                            </li>
                                            <li class="cursor-pointer" @click="shareLinkedIn"><vue-feather type="linkedin"/></li>
                                        </ul>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <button @click="watchlistStore.removeFromWishList(product)"
                                                v-if="watchlistStore.wishList.find(item => item.id === product?.id)"
                                                class="d-flex align-items-center gap-1 btn btn-primary btn-icon rounded-md">
                                            <vue-feather type="bookmark"/>
                                            <span>Saved</span>
                                        </button>
                                        <button @click="addToWishList(product)" v-else class="btn d-flex align-items-center gap-1 btn btn-primary btn-icon rounded-md">
                                            <vue-feather type="bookmark"/>
                                            <span>Save</span>
                                        </button>

<!--                                        -->
<!--                                        <button class="d-flex align-items-center gap-1 btn btn-primary btn-icon rounded-md">-->
<!--                                            <vue-feather type="bookmark"/>-->
<!--                                            <span>Save</span>-->
<!--                                        </button>-->
<!--                                        <button class="d-flex align-items-center gap-1 btn btn-primary btn-icon rounded-md">-->
<!--                                            <vue-feather type="layers"/>-->
<!--                                            <span>Add to Compare</span>-->
<!--                                        </button>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2 gap-5">
                        <div class="col-12 col-md-5">
                            <div class="row flex-column">
                                <LightBox class="d-block d-lg-none" :images="images"/>
                                <Gallery class="d-none d-lg-block" :images="images"/>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
<!--                            <h1>Sku Id : #_{{ product?.sku }}</h1>-->

                            <h2 class="text-capitalize mt-2 text-primary" v-text="product?.title"></h2>

<!--                            <span class="card-text item-company">By
                                <a href="#" class="company-name">{{ product?.brand?.name }}</a> & Category By
                                <a href="#" class="company-name">{{ product?.category?.title }}</a>
                            </span>-->
                            <div class="ecommerce-details-price d-flex flex-wrap mt-3 flex-column">
                                <div>
                                    <h2 class="fw-bolder text-black">Key Featureds</h2>
                                    <p class="white-space fw-semibold text-black mt-2" v-text="product?.description"></p>
                                    <a href="#" class="fs-4 view-more-info text-decoration-underline"> View more information's</a>
                                </div>

                                <div class="mt-2 w-lg-50 w-100">
                                    <h3 class="text-black">Payment Option</h3>
                                    <div class="d-flex align-items-center gap-3 border-5 border-primary p-1">
                                        <div>
                                            <vue-feather type="check-circle"/>
                                        </div>
                                        <div class="">
                                            <p class="m-0 fs-2 fw-bolder text-black mb-1">{{ product?.discount > 0  ? product?.discount : product?.price }} ৳</p>
                                            <p class="m-0 fw-bold text-black">Buy with Latest price</p>
                                            <p class="m-0 text-black">Online / Cache Payment</p>
                                        </div>
                                    </div>
                                </div>


<!--
                                <h4 class="item-price me-1">
                                    <s v-if="discountPrice">{{ $showPrice(product?.price) }}</s>
                                    <span v-else>{{ $showPrice(product?.price) }}</span>
                                </h4>
                                <h4 class="item-price me-1" v-if="discountPrice">
                                    {{ discountPrice ? '| '+ $showPrice(discountPrice) : '' }}
                                    <span class="discount-span" :class="data.spanIsRed ? 'discount-span-red' : 'discount-span-black' " v-if="discountPrice">
                                        {{ props.discountData.discount_price }} {{ props.discountData.discount_type === 'flat' ? data.priceSignature : '%' }} Off
                                    </span>
                                </h4>-->

<!--                                <ul class="unstyled-list list-inline ps-1 border-start">
                                    <li class="ratings-list-item" v-for="item in 4">
                                        <vue-feather type="star" class="filled-star"/>
                                    </li>
                                    <li class="ratings-list-item">
                                        <vue-feather type="star" class="unfilled-star"/>
                                    </li>
                                </ul>-->


                            </div>
<!--                            <p class="card-text">Available - <span class="text-success">{{ product?.qty > 0 ? 'In stock' : 'Out of stock' }}</span></p>-->

<!--                            <ul class="product-features list-unstyled">
                                <li class="d-flex align-items-center mb-1">
                                    <vue-feather type="shopping-cart"/>
                                    <span class="ms-1">Free Shipping</span>
                                </li>
                            </ul>-->


<!--                            <div class="row">
&lt;!&ndash;                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4>Color</h4>
                                            <div class="color-box p-1 d-block" :style="{background:color?.code}"></div>
                                            <small>{{ color?.name }}</small>
                                        </div>
                                    </div>
                                </div>&ndash;&gt;
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4>Size's</h4>
                                            <select class="select2 form-select" @change="selectSize">
                                                <option value="null" selected disabled>I want this size.</option>
                                                <option :value="item" v-for="item in JSON.parse(product?.sizes)">{{ item }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10" v-if="sizeRadio">
                                    <div class="card" v-for="item in JSON.parse(product?.sizes)">
                                        <div class="card-header">
                                            <h4 class="card-title">Basic Radio</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row custom-options-checkable g-1">
                                                <div class="col">
                                                    <input class="custom-option-item-check" type="radio" name="customOptionsCheckableRadios" id="customOptionsCheckableRadios1" value="">
                                                    <label class="custom-option-item p-1" for="customOptionsCheckableRadios1">
                                                        {{ item }}
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <input class="custom-option-item-check" type="radio" name="customOptionsCheckableRadios" id="customOptionsCheckableRadios2" value="">
                                                    <label class="custom-option-item p-1" for="customOptionsCheckableRadios2">
                                                        {{ item }}
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <input class="custom-option-item-check" type="radio" name="customOptionsCheckableRadios" id="customOptionsCheckableRadios3" value="">
                                                    <label class="custom-option-item p-1" for="customOptionsCheckableRadios3">
                                                        {{ item }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->

                            <div class="d-flex flex-row flex-wrap pt-1 gap-0 gap-lg-2 align-items-start justify-content-lg-start justify-content-between">
                                <div class="d-flex align-items-center w-lg-30 w-md-50 cart-btn-radius">
                                    <button @click="decrement" class="btn btn-primary fs-3 fw-bolder rounded-start" >-</button>
                                    <input  class="form-control rounded-0 qty-input-p text-center" readonly type="text" :value="initCart" min="1">
                                    <button @click="increment" class="btn btn-primary fs-3 fw-bolder rounded-end" >+</button>
                                </div>
                                <div>
                                    <button @click="addToCart(product)"  class="btn sm-cart-btn btn-primary me-0 me-sm-1 mb-1 mb-sm-0 d-flex align-items-center">
                                        <vue-feather type="shopping-cart" class="me-50"/>
                                        <span class="add-to-cart">{{"Add to cart"}}</span>
                                    </button>
<!--                                    <button v-else @click="store.incrementQty(product?.id)"
                                            :disabled="isInCart === product?.qty"
                                            class="btn btn-primary btn-cart me-0 me-sm-1 mb-1 mb-sm-0 d-flex align-items-center">
                                        <vue-feather type="shopping-cart" class="me-50"/>
                                        <span class="add-to-cart">{{ isInCart+" Item In Cart" }}</span>
                                    </button>-->
                                </div>

<!--                                <button @click="watchlistStore.removeFromWishList(product)"-->
<!--                                        v-if="watchlistStore.wishList.find(item => item.id === product?.id)"-->
<!--                                        class="btn btn-outline-secondary btn-wishlist me-0 me-sm-1 mb-1 mb-sm-0 d-flex align-items-center">-->
<!--                                    <vue-feather type="heart" class="me-50"/>-->
<!--                                    <span>Remove Form Wishlist</span>-->
<!--                                </button>-->

<!--                                <button @click="addToWishList(product)" v-else class="btn btn-outline-secondary btn-wishlist me-0 me-sm-1 mb-1 mb-sm-0 d-flex align-items-center">-->
<!--                                    <vue-feather type="heart" class="me-50"/>-->
<!--                                    <span>Add To Wishlist</span>-->
<!--                                </button>-->


<!--                                <div class="btn-group dropdown-icon-wrapper btn-share">
                                    <button type="button" class="btn btn-icon hide-arrow btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <vue-feather type="share-2"></vue-feather>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item d-flex align-items-center">
                                            <vue-feather type="facebook"/>
                                            <span class="add-to-cart ms-1">Facebook</span>
                                        </a>
                                        <a href="#" class="dropdown-item d-flex align-items-center">
                                            <vue-feather type="twitter"/>
                                            <span class="add-to-cart ms-1">Twitter</span>
                                        </a>
                                        <a href="#" class="dropdown-item d-flex align-items-center">
                                            <vue-feather type="instagram"/>
                                            <span class="add-to-cart ms-1">Facebook</span>
                                        </a>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<!--
            <div class="card">
                <div class="card-body">
                    &lt;!&ndash; Item features starts &ndash;&gt;
                    <div class="item-features">
                        <div class="row text-center">
                            <div class="col-12 col-md-4 mb-4 mb-md-0">
                                <div class="w-75 mx-auto">
                                    <i data-feather="award"></i>
                                    <h4 class="mt-2 mb-1">100% Original</h4>
                                    <p class="card-text">Chocolate bar candy canes ice cream toffee. Croissant pie cookie halvah.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-4 mb-md-0">
                                <div class="w-75 mx-auto">
                                    <i data-feather="clock"></i>
                                    <h4 class="mt-2 mb-1">10 Day Replacement</h4>
                                    <p class="card-text">Marshmallow biscuit donut dragée fruitcake. Jujubes wafer cupcake.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-4 mb-md-0">
                                <div class="w-75 mx-auto">
                                    <i data-feather="shield"></i>
                                    <h4 class="mt-2 mb-1">1 Year Warranty</h4>
                                    <p class="card-text">Cotton candy gingerbread cake I love sugar plum I love sweet croissant.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    &lt;!&ndash; Item features ends &ndash;&gt;
                </div>
            </div>
-->

            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <div class="details-btn-grup d-flex align-items-center gap-1 mb-2">
                            <button class="fw-bolder text-black btn btn-primary">Specifications</button>
<!--                            <button class="fw-bolder text-black btn bg-white page-shadow">Descriptions</button>-->
<!--                            <button class="fw-bolder text-black btn bg-white page-shadow">Questions</button>-->
<!--                            <button class="fw-bolder text-black btn bg-white page-shadow">Reviews</button>-->
                        </div>
                        <div class="card page-shadow">
                            <div class="card-body spesificaiton">
                                <span v-html="product?.specification"></span>
                            </div>
                        </div>

                        <div class="row match-height home-featured-product">
                            <div class="mb-2">
                                <h4>Related Products</h4>
                                <p class="card-text">People also search for this items</p>
                            </div>
                            <div class="col-lg-3 col-md-3 product-item"
                                 :class="i % 2 === 0? 'pr-m-5': 'pl-m-5'"
                                 v-for="(product, i) in product?.category?.products">
                                <StarTProducts :product="product"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 sticky-top" style="max-height: 100vh; overflow-y:scroll; z-index:1">
                        <div class="card page-shadow">
                            <div class="card-body">
                                <h2 class="card-title">Products This Brand</h2>
                            </div>
                        </div>
                        <div class="row match-height brand-products">
                            <div class="col-lg-12 col-md-3 product-item"
                                 :class="i % 2 === 0? 'pr-m-5': 'pl-m-5'"
                                 v-for="(product, i) in product?.brand?.products">
                                <StarTProducts :product="product"/>
                            </div>
                        </div>

<!--                        <StarTProducts v-for="item in product?.category?.products" :product="item" :key="'related_productes'+item.id"/>-->

<!--                        <div class="card page-shadow" v-for="item in product?.category?.products" :key="'related_productes'+item.id">
                            <div class="card-body">
                                <div>
                                    <img class="card-img-top w-100 star-pro-img" :src="props.product.thumbnail" alt="">
                                    <div>
                                        <a href="">product title</a>
                                        <p>price</p>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>


        </section>
    </Layout>
</template>

<style scoped>

    .white-space{
        white-space:break-spaces;
    }
    .card-shadow{
        box-shadow: 0 0px 14px -1px rgb(34 41 47 / 32%) !important;
    }
    .color-box{
        width: 100px;
        height: 15px;
    }
    /*.carousel__slide{*/
    /*    margin: 0 1rem;*/
    /*}*/
    .discount-span{
        padding: 4px 15px;
        border-radius: 50px;
    }
    .view-more-info:hover{
        color:red;
        text-decoration:underline;
    }
    .details-btn-grup button:hover{
        background-color: var(--bs-primary) !important;
        color: white !important;
    }
</style>
