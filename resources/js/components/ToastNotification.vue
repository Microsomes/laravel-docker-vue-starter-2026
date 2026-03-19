<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

interface Notification {
    id: number;
    message: string;
    timestamp: string;
}

const notifications = ref<Notification[]>([]);
let nextId = 0;

function addNotification(message: string, timestamp: string) {
    const id = nextId++;
    notifications.value.push({ id, message, timestamp });

    setTimeout(() => {
        notifications.value = notifications.value.filter((n) => n.id !== id);
    }, 5000);
}

onMounted(() => {
    window.Echo.channel('demo').listen('.notification.sent', (event: { message: string; timestamp: string }) => {
        addNotification(event.message, event.timestamp);
    });
});

onUnmounted(() => {
    window.Echo.leaveChannel('demo');
});
</script>

<template>
    <div class="fixed top-4 right-4 z-50 flex flex-col gap-2">
        <TransitionGroup name="toast">
            <div
                v-for="notification in notifications"
                :key="notification.id"
                class="rounded-lg border border-[#19140035] bg-white px-4 py-3 shadow-lg dark:border-[#3E3E3A] dark:bg-[#1a1a1a]"
            >
                <p class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                    {{ notification.message }}
                </p>
            </div>
        </TransitionGroup>
    </div>
</template>

<style scoped>
.toast-enter-active {
    transition: all 0.3s ease-out;
}
.toast-leave-active {
    transition: all 0.3s ease-in;
}
.toast-enter-from {
    opacity: 0;
    transform: translateX(30px);
}
.toast-leave-to {
    opacity: 0;
    transform: translateX(30px);
}
</style>
