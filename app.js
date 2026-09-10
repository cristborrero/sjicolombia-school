import dotenv from "dotenv";
import OpenAI from "openai";

dotenv.config();

const openai = new OpenAI({
    apiKey: process.env.XKIRO_API_KEY,
    baseURL: process.env.XKIRO_BASE_URL,
});

const modelos = [
    "qwen/qwen3.8-max:free",
    // otros modelos disponibles
];

async function probarModelos() {
    for (const modelo of modelos) {
        try {
            console.log(`\n===== ${modelo} =====\n`);

            const chat = await openai.chat.completions.create({
                model: modelo,

                messages: [
                    {
                        role: "user",
                        content: "øQuÈ es JavaScript?",
                    },
                ],
            });

            console.log(chat.choices[0].message.content);
        } catch (error) {
            console.log(`Error con ${modelo}:`, error.message);
        }
    }
}

probarModelos();