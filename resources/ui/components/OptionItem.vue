<script setup lang="ts">

const emit = defineEmits(['close'])

defineProps({
    title: { type: String, required: true },
    iconTitle: { type: String, required: true },
    subtitle: { type: String, required: true },
    buttonLabel: { type: String, required: true },
})
</script>

<template>
    <div class="card">
        <section class="card-header">
            <div class="header-content">
                <div class="icon-wrapper">
                    <span class="material-symbols-outlined icon-title">{{ iconTitle }}</span>
                </div>
                <h1>{{ title }}</h1>
            </div>
            <span class="material-symbols-outlined icon-arrow">keyboard_arrow_right</span>
        </section>

        <section class="card-subtitle">
            <p>{{ subtitle }}</p>
        </section>

        <button>{{ buttonLabel }}</button>
    </div>
</template>

<style scoped>
h1,
p {
    color: #141414;
    font-family: Montserrat, sans-serif;
    margin: 0;
}

h1 {
    font-size: 24px;
    font-weight: 600;
}

p {
    font-size: 16px;
    font-weight: 500;
}

button {
    background: linear-gradient(45deg, #D35614, #F9A053);
    border: none;
    border-radius: 12px;
    height: 56px;
    color: #F0F5F2;
    cursor: pointer;
    width: 50%;
    font-family: Montserrat, sans-serif;
    font-size: 16px;
    font-weight: 600;
    padding-block: 16px;
    box-sizing: border-box;
    margin-inline: 16px;
    margin-bottom: 16px;
}

button:hover {
    background: linear-gradient(45deg, #F6741C, #B13C0E);
}

button:active {
    background: linear-gradient(45deg, #D35614, #8E2708);
}

.card {
    background-color: white;
    border-radius: 24px;
    border: 1px solid #B0B8B3;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 600px;
    transition: border-color 0.3s;
}

.card:hover {
    border: 1px solid #F6741C;
}

.card:hover .card-header {
    background-color: #FEEED1;
}

.card-header {
    display: flex;
    border-top-left-radius: 24px;
    border-top-right-radius: 24px;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding-inline: 16px;
    padding-block: 20px;
}

.card-subtitle {
    margin-top: 8px;
    margin-bottom: 24px;
    padding-inline: 16px;
}

.header-content {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 8px;
}

.icon-arrow {
    color: #141414;
}

.icon-wrapper {
    display: flex;
    border-radius: 50%;
    background-color: #FEEED1;
    color: #F6741C;
    padding: 8px;
    box-sizing: border-box;
}

.icon-title {
    font-size: 32px;
}
</style>
