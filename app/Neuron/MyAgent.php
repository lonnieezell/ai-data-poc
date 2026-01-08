<?php

declare(strict_types=1);

namespace App\Neuron;

use NeuronAI\Agent;
use NeuronAI\Chat\History\ChatHistoryInterface;
use NeuronAI\Chat\History\FileChatHistory;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Providers\HttpClientOptions;
use NeuronAI\Providers\OpenAI\Responses\OpenAIResponses;
use NeuronAI\SystemPrompt;
use NeuronAI\Tools\Toolkits\MySQL\MySQLToolkit;

class MyAgent extends Agent
{
    public function __construct(
        protected string $threadId = 'default'
    ) {}

    protected function provider(): AIProviderInterface
    {
        return new OpenAIResponses(
            key: config('services.openai.key'),
            model: config('services.openai.model'),
            parameters: [], // Add custom params (temperature, logprobs, etc)
            strict_response: false, // Strict structured output
            httpOptions: new HttpClientOptions(timeout: 30),
        );
    }

    protected function chatHistory(): ChatHistoryInterface
    {
        return new FileChatHistory(
            directory: storage_path('neuron'),
            key: $this->threadId,
            contextWindow: 50000
        );
    }

    public function instructions(): string
    {
        return (string) new SystemPrompt(
            background: [
                'You are a data analysis AI Agent specialized in analyzing quality-of-life and longevity data.',
                "Your role is to help users understand patterns, correlations, and insights from a dataset containing 10,000 records of individuals' work-life balance metrics and their ages at death.",
                'You have access to a database tool that contains the actual data. Use ONLY this tool to retrieve and analyze data.',
                'You must NOT make up data, use external sources, or rely on general knowledge. All insights must come from querying the database.',
            ],
            steps: [
                "Parse the user's question to understand what aspect of work-life balance or longevity they want to explore.",
                'Use the database tool to query relevant records based on the available data points: gender, occupation type, daily work hours, daily rest hours, daily sleep hours, daily exercise hours, and age at death.',
                'Perform statistical analysis on the retrieved data (correlations, trends, comparisons, distributions).',
                'Base your insights exclusively on data returned from the database queries.',
                'If the database returns insufficient data or empty results, explain this to the user rather than speculating.',
            ],
            output: [
                'Provide clear, analytical responses focused on the relationship between work-life balance factors and longevity.',
                'Use specific numbers, percentages, and statistics directly from your database queries.',
                'Highlight patterns and correlations found in the actual data.',
                'When making comparisons, clearly state the groups being compared and cite the counts/percentages from your queries.',
                'Always mention when data is directly from the database and reference the number of records analyzed.',
                'If a question cannot be answered because the data does not exist or is insufficient, explain why clearly and avoid speculation.',
                'Never provide insights based on general knowledge or external information—only use database results.',
            ]
        );
    }

    protected function tools(): array
    {
        $pdo = $this->getDatabaseConnection();

        return [
            MySQLToolkit::make($pdo),
        ];
    }

    private function getDatabaseConnection(): \PDO
    {
        $driver = config('database.default');
        $config = config("database.connections.{$driver}");

        if ($driver === 'sqlite') {
            return new \PDO("sqlite:{$config['database']}");
        }

        if ($driver === 'mysql') {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $config['host'],
                $config['port'],
                $config['database']
            );

            return new \PDO(
                $dsn,
                $config['username'],
                $config['password']
            );
        }

        throw new \RuntimeException("Unsupported database driver: {$driver}");
    }
}
