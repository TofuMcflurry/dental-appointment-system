import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                // Patient dashboard assets
                'resources/css/patient/patient.css',
                'resources/js/patient/core.js',
                'resources/js/patient/dashboard.js',
                'resources/js/patient/appointments.js',
                'resources/js/patient/notification.js',
                'resources/js/patient/settings.js',
                // Admin dashboard assets
                'resources/css/admin/dashboard.css',
                'resources/js/admin/dashboard.js',
                'resources/css/admin/appointments.css',
                'resources/js/admin/appointments.js',
                'resources/css/admin/audittrail.css',
                'resources/js/admin/audittrail.js',
                'resources/css/admin/patients.css',
                'resources/js/admin/patients.js',
                'resources/css/admin/settings.css',
                'resources/js/admin/settings.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',
    },
});