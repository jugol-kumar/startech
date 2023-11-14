<template>
    <transition name="fade">
        <div class="preloader">
            <!--            <div class="logo">-->
            <!--                <img src="../../images/loading2.svg" alt="">-->
            <!--            </div>-->
            <!--            <p>Please Wait...!</p>-->

            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </transition>
</template>

<script setup>
//
</script>

<style scoped>
.preloader {
    background: var(--bs-primary);/*v-bind('props.backgroundColor');*/
}
</style>
