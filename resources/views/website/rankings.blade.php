@extends('layouts.mystical')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('site.rankings.title'))

@section('body-class', 'rankings-page')


@section('content')
<div class="content-section">
    <div class="rankings-container">
            <!-- Top Players Section -->
            <div class="ranking-section">
                <h2 class="section-title">{{ __('site.rankings.top_players') }}</h2>
                <!-- Debug: {{ $topPlayers->count() }} players found -->
                <div class="ranking-table">
                    @if($topPlayers->count() == 0)
                        <div style="text-align: center; padding: 40px; color: #b19cd9;">
                            {{ __('site.rankings.no_players') }}
                        </div>
                    @endif
                    @foreach($topPlayers as $index => $player)
                        <div class="ranking-row">
                            <div class="rank-number @if($index < 3) rank-{{ $index + 1 }} @endif">
                                {{ $index + 1 }}
                            </div>
                            <div class="player-info">
                                <div class="player-name">{{ $player->name }}</div>
                                <div class="player-details">
                                    @php
                                        $classKey = 'site.rankings.classes.' . $player->cls;
                                        $className = __($classKey) !== $classKey ? __($classKey) : __('site.rankings.classes.unknown');
                                    @endphp
                                    {{ $className }}
                                </div>
                            </div>
                            <div class="player-level">
                                {{ __('site.rankings.level') }} {{ $player->level }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Factions Section -->
            <div class="ranking-section">
                <h2 class="section-title">{{ __('site.rankings.top_factions') }}</h2>
                <div class="ranking-table">
                    @if($topFactions && count($topFactions) > 0)
                        @foreach($topFactions as $index => $faction)
                            <div class="ranking-row">
                                <div class="rank-number @if($index < 3) rank-{{ $index + 1 }} @endif">
                                    {{ $index + 1 }}
                                </div>
                                <div class="player-info">
                                    <div class="player-name">
                                        {{-- Temporarily removed icon code to debug --}}
                                        {{ $faction->name }}
                                    </div>
                                    <div class="player-details">
                                        {{ __('site.rankings.members') }} {{ $faction->members }}
                                    </div>
                                </div>
                                <div class="player-level">
                                    {{ __('site.rankings.level') }} {{ $faction->level }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 40px; color: #b19cd9;">
                            {{ __('site.rankings.no_factions') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- PvP Rankings Section -->
        <div class="content-section" style="margin-top: 40px;">
            <h2 class="section-title" style="color: #ff6b6b; text-shadow: 0 0 30px rgba(255, 107, 107, 0.8);">{{ __('site.rankings.pvp_champions') }}</h2>
            <div class="ranking-table">
                @foreach($topPvPPlayers as $index => $player)
                    <div class="ranking-row">
                        <div class="rank-number @if($index < 3) rank-{{ $index + 1 }} @endif">
                            {{ $index + 1 }}
                        </div>
                        <div class="player-info">
                            <div class="player-name">{{ $player->name }}</div>
                            <div class="player-details">
                                @php
                                    $classKey = 'site.rankings.classes.' . $player->cls;
                                    $className = __($classKey) !== $classKey ? __($classKey) : __('site.rankings.classes.unknown');
                                @endphp
                                {{ $className }} - {{ __('site.rankings.level') }} {{ $player->level }}
                            </div>
                        </div>
                        <div class="player-level" style="background: linear-gradient(45deg, #ff6b6b, #dc3545); min-width: 100px;">
                            {{ $player->pk_count }} {{ __('site.rankings.kills') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
</div>
@endsection

