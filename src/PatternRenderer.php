<?php

namespace eLife\Patterns;

interface PatternRenderer
{
    public function render(ViewModel $viewModel) : string;
}
