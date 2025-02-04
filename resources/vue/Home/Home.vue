<script setup lang="ts">
</script>

<template>
    <div class="background">
        <div class="content">
            <section class="area-section">
                <p>Área dos Dispositivos</p>
            </section>
        </div>
    </div>
</template>

<style scoped>
p {
    color: #032826;
    font-family: Montserrat;
    font-size: 32px;
    font-weight: 600;
    margin: 0;
}

.area-section {
    background-color: white;
    border: 1px solid #B0B8B3;
    border-radius: 24px;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 16px;
    padding-block: 20px;
    padding-inline: 24px;
}

.background {
    background-color: #F0F5F2;
    display: flex;
    flex-direction: column;
    align-items: start;
    justify-content: end;
    height: 100vh;
}

.content {
    display: flex;
    flex-direction: column;
    padding: 32px;
    height: 100%;
    width: 100%;
    box-sizing: border-box;
}
</style>