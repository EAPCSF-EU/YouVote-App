<?php

namespace backend\models;

interface VotingAlgorithm
{
    public function calculate(array $contest): array;
}