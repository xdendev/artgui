FROM node:20-alpine

WORKDIR /app

# Копируем package файлы и устанавливаем зависимости
COPY package*.json ./
RUN npm ci

# Копируем конфиги и исходники
COPY vite.config.js ./
COPY resources ./resources

# По умолчанию - production сборка
CMD ["npm", "run", "build"]