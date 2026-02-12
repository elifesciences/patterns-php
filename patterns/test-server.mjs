import express from 'express';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
const PORT = process.env.PORT || 8888;

app.use('/test', express.static(path.join(__dirname, 'test')));

app.use('/node_modules', express.static(path.join(__dirname, 'node_modules')));

app.get('/', (_request, response) => response.write("OK"))

const server = app.listen(PORT, () => {
  console.log(`Test server running at http://localhost:${PORT}`);
});

process.on('SIGTERM', () => {
  console.log('SIGTERM received, closing server...');
  server.close(() => {
    console.log('Server closed');
    process.exit(0);
  });
});
