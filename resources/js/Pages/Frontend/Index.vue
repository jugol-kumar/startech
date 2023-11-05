<script setup>
    import TopHeader from "../Frontend/Shared/TopHeader.vue"
    import Header from "../Frontend/Shared/Header.vue"
    import HeaderMenu from "../Frontend/Shared/HeaderMenu.vue"

    import 'vue3-carousel/dist/carousel.css'
    import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
    import {computed, onMounted, ref} from 'vue'
    import CardCarosel from "../../components/CardCarousel.vue";
    import ProductCarousel from "./Modules/ProductCarousel.vue";
    import AdsSection from "./Modules/AdsSection.vue";
    import Layout from "./Shared/Layout.vue";
    import FeaturedCategories from "./Pages/FeaturedCategories.vue";
    import Products from "./Pages/StarTProducts.vue";
    import {useDataStore} from "../../Store/useDataStore";
    import {useCartStore} from "../../Store/useCartStore";

    const store = useDataStore();
    const cartStore = useCartStore();

    const props = defineProps({
        homeProducts:[]|null,
        sliders:[]|null,
        advised:[]|null,

        pageData:[]|null,
    })

    const sliders = ref({pagination:false, navigation:false,})


    const slides = computed(() =>{
        if (props.banners[0]?.info){
            return JSON.parse(props.banners[0]?.info);
        }
    })
    onMounted(()=>{
        store.initFeaturedCategories()
        cartStore.initCart()
    })
    import b1 from "../../../images/psc/b1.jpg"
    import b2 from "../../../images/psc/b2.jpg"
    import b3 from "../../../images/psc/b3.jpg"
    import b4 from "../../../images/psc/PolyScience-Logo.png"
    import b5 from "../../../images/psc/President-Message.jpg"
    import b6 from "../../../images/psc/RADWAG.jpg"
    import b7 from "../../../images/psc/Rocker-Logo.png"
    import b8 from "../../../images/psc/TOP6.jpg"
    import b9 from "../../../images/psc/YL-Instrument.png"
    const images = [b3,b4,b5,b1,b2,b5,b1,b2,b3,b4,b5,b6,b7,b8,b9]

</script>

<template>
    <Head title="Home Page">

    </Head>
    <Layout>
        <div class="bg-white page-shadow">
            <div class="container">
                <section class="py-3">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row match-height slider-section ms-auto">
                                <Carousel :autoplay="5000" :wrap-around="true" v-if="false">
                                    <Slide v-for="slide in props.sliders" :key="slide">
                                        <div class="carousel__item">
                                            <img :src="`/storage/${slide.image}`" alt="">
                                        </div>
                                    </Slide>
                                    <template #addons>
                                        <Navigation/>
                                        <Pagination/>
                                    </template>
                                </Carousel>
                                <Carousel :wrap-around="true" v-else>
                                    <Slide v-for="slide in props.sliders" :key="slide">
                                        <div class="carousel__item">
                                            <img :src="`/storage/${slide.image}`" alt="">
                                        </div>
                                    </Slide>
                                    <template #addons>
                                        <Navigation/>
                                        <Pagination/>
                                    </template>
                                </Carousel>
                            </div>
                        </div>
                        <div class="col-md-3 home-ads ads-bg">
                            <div class="row">
                                <div class="col-md-12 mt-1" v-for="adds in props.advised">
                                    <div class="card page-shadow">
                                        <div class="card-body">
                                            <img class="w-100" :src="adds.image" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="container">
            <section id="featured-categories" >
                <div class="text-center my-5">
                    <h2 class="text-black fw-bolder">Featured Category</h2>
                    <p class="text-black">Get Your Desired Product from Featured Category!</p>
                </div>


                <div class="display-grid">
                    <a href="#" class="single-item" v-for="item in store.getTopCategories">
                        <div class="card page-shadow">
                            <div class="card-body">
                                <img :src="`${item.icon}`" alt="" width="75">
                                <a class="fw-bolder" href="#">{{ item.title }}</a>
                            </div>
                        </div>
                    </a>
                </div>
            </section>




            <section id="dashboard-ecommerce" class="sm-mt-15-rem-min">
                <div class="text-center my-5 text-black">
                    <h2 class="text-black fw-bolder">Featured Products</h2>
                    <p class="text-black">Check & Get Your Desired Product!</p>
                </div>
                <div class="row match-height">
                    <div class="col-lg-3 mb-4 col-md-3 product-item" v-for="product in props.homeProducts">
                        <Products :product="product"/>
                    </div>
                </div>

                <!--            <FeaturedCategories :categories="props.pageData.homeCats"/>-->



                <!--
                            <section v-for="cats in store.getFeaturedCategories">
                                <div class="mt-3">
                                    <h3>{{ cats.title }}</h3>
                                </div>
                            </section>-->


            </section>
            <section id="category-with-details" class="sm-mt-15-rem-min mt-3 mb-5">
                <h2 class="text-black">Preferred Area of Our Work</h2>
                <p class="text-black" style="line-height:2; font-weight: 500">We are capable to supply and support for all Scientific laboratory products in Bangladesh. We also preferred Pharmaceuticals Industries, Textile, Food industries, University Laboratory and Fisheries Industries Project to supply our products. We are a supplier of University laboratory equipment, college laboratory equipment, textile testing instruments & consumables, food lab equipment, health & safety materials, fish farming items, and cement industries testing equipment and in Bangladesh.</p>

                <h2 class="text-black mt-2">Best Scientific Instruments Seller in Dhaka, Bangladesh</h2>
                <p class="text-black" style="line-height:2; font-weight: 500">Paradise Scientific Company Ltd. is an online shop and supplier, importer of scientific laboratory items. psc.com.bd carries Seven Hundred or more of lab instruments such as Autoclave, Air Sampler, weight scales, Digital Balance, HPLC System,  GC System,  Balance, Scale & Standard Weight, Laboratory Oven, Bio-Chemistry Analyzer, Bio-Hazard Safety Cabinet, Biological Safety Cabinet, Bio-Suction Pump, Block Heater, BOD Analyzer, BOD Incubator/Incubator, Bulk Density, Burette Digital, Microscope Camera, Centrifuge Machine, Chiller, COD Analyzer, COD Colorimeter, Cold Trap, Colony Counter, Colorimeter Conductivity Meter, Data-Logger, Digestion System (Food Analysis), Digestion Unit (Kjeldhal), Bottle top Dispenser, Disintegration Tester, Dissolution Tester, Distillation Unit, DO Meter, , Dissolved Oxygen Meter, Drying Oven, Elisa Reader, Eye Shower, Fat Extraction System (Food Analysis), Fermenter & Bioreactor, Fiber Extraction System (Food Analysis), Filtration Unit (Vacuum), Freezer, Friability Tester, FT-IR, Fume Hood, Fume Photometer, Gas Generator, GC (Gas Chromatograph), Gel Documentation System, Gel Dryer, Gel Electrophoresis, Growth Chamber, moisture analyzing, Micro balance, vernier calipers, physics, chemistry and biology laboratory products. Paradise Scientific company Ltd. also a retailer, supplier, procurement provider, Importer of lab products and services such as glass and plastic-ware, model, lab balance & Lab equipment, and supply in scientific research and applied science and life science.</p>

                <h2 class="text-black mt-2 font-medium">Hi-tech product selling category</h2>
                <p class="text-black" style="line-height:2; font-weight: 500">We are always the stockiest and stock all types of products for all kinds of laboratories in Bangladesh. Our best selling products are Pharmaceutical Industries, University, Food Industries, Fish Farming, government institute etc. such as Hardness Tester Digital, Heating Mantle, Homogenizer, Hotplate & Stirrer, HPLC (High Perf. Liquid Chrom.), HPLC Column, Hygrometer, Laboratory Incubator ( Force, Natural, Shaking etc.), Karl Fischer Titratior, Lab Basin/Triple Outlet, Lab Furniture, Laminar Flow Cabinet, LC-MS, Leak Test Apparatus, Liquid Nitrogen Container, Mass Comparator, Melting Point Apparatus, Micropipette, Micro-Plate Mixer, Microplate Reader, Laboratory Microscope, Muffle Furnace, PCR (Thaermal Cycler), PH Meter (with Multi Parameter), Pipette Controller, Polarimeter, Potentiometric Tritator, Powder Flow Meter, Power Supply, Refractometer, Refrigerated Bath Circulator, Laboratory Refrigerator, Rotary Evaporator, Bio Safety Cabinet, Seed Germinator, Shaker, (Orbital/Sieve/Rocker), Sonicator (Ultrasonic Cleaner), Soxhlet Apparatus, Spectrophotometer, Stability/Humidity Chamber, Sterilizer, Viscometer, Vortex Meter, Water Bath, Water Distiller, Water Purification, Tab Density Tester, Tablet Disintegration Tester, Tablet Dissolution Tester, Tablet Friability Tester, Tablet Powder Flow Meter, Test Kit (Laboratory), Thermometer, Titrator Manual/Digital, TLC (Thin Layer Chromatography), TOC Analyzer, TSS/MLSS Meter, Turbidity Meter, Digital Weight Scale, T-Scale, Laboratory Glassware & Instruments Labor</p>
            </section>
        </div>
    </Layout>
</template>

<style scoped>

/*.carousel__item {*/
/*    min-height: 400px;*/
/*    width: 100%;*/
/*    background-color: var(--vc-clr-primary);*/
/*    color: var(--vc-clr-white);*/
/*    font-size: 20px;*/
/*    border-radius: 8px;*/
/*}*/

.carousel__item, .carousel__item img{
    width: 100% !important;
    height: 100% !important;
}
/*.header-before:before{*/
/*    content: '';*/
/*    width: 12rem;*/
/*    height: 1px;*/
/*    background: var(--bs-primary);*/
/*    position: absolute;*/
/*    top: 2rem;*/
/*    left: 21%;*/
/*}*/
.header-before::before,
.header-before::after{
    display: inline-block;
    content: "";
    border-top: .1rem solid var(--bs-primary);
    width: 10rem;
    margin: 0 1rem;
    transform: translateY(-1rem);

    /*content: '';*/
    /*width: 12rem;*/
    /*height: 1px;*/
    /*background: var(--bs-primary);*/
    /*position: absolute;*/
    /*top: 2rem;*/
}
.ads-bg{
    background:#f2f4f8;
}



#featured-categories .display-grid{
    display: grid;
    grid-template-columns: auto auto auto auto auto auto auto auto;
    grid-template-rows: auto auto;
    gap: 1rem 1rem;
}

#featured-categories .display-grid .single-item .card{
    margin-bottom: 2rem;
    /*box-shadow: 0 5px 5px -4px #0c1e2c;*/
    transition: all 0.3s ease-in-out, background 0s, color 0s, border-color 0s;
    border-radius: 20px;
}
#featured-categories .display-grid .single-item .card-body{
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
    gap: 1rem;
    text-align: center;
}

.home-ads{
    overflow-y: scroll;
    max-height: 381px;
}
</style>
