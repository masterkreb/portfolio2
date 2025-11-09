<?php
// Rate Limiting Klasse für Formular-Submissions

class RateLimiter {
    private $logFile;
    private $maxAttempts;
    private $timeWindow;
    
    public function __construct($logFile = 'rate_limit.log', $maxAttempts = 3, $timeWindow = 3600) {
        // Log-Datei sollte außerhalb des public_html Ordners liegen
        $this->logFile = __DIR__ . '/' . $logFile;
        $this->maxAttempts = $maxAttempts;
        $this->timeWindow = $timeWindow;
        
        // Erstelle Log-Datei falls nicht vorhanden
        if (!file_exists($this->logFile)) {
            touch($this->logFile);
            chmod($this->logFile, 0600); // Nur Owner kann lesen/schreiben
        }
    }
    
    public function isAllowed($identifier) {
        $this->cleanOldEntries();
        $attempts = $this->getAttempts($identifier);
        
        return $attempts < $this->maxAttempts;
    }
    
    public function recordAttempt($identifier) {
        $timestamp = time();
        $entry = $timestamp . '|' . $identifier . "\n";
        file_put_contents($this->logFile, $entry, FILE_APPEND | LOCK_EX);
    }
    
    private function getAttempts($identifier) {
        if (!file_exists($this->logFile)) {
            return 0;
        }
        
        $lines = @file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return 0;
        }
        
        $cutoff = time() - $this->timeWindow;
        $count = 0;
        
        foreach ($lines as $line) {
            $parts = explode('|', $line);
            if (count($parts) !== 2) {
                continue;
            }
            
            list($timestamp, $ip) = $parts;
            if ($ip === $identifier && $timestamp > $cutoff) {
                $count++;
            }
        }
        
        return $count;
    }
    
    private function cleanOldEntries() {
        if (!file_exists($this->logFile)) {
            return;
        }
        
        $lines = @file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }
        
        $cutoff = time() - $this->timeWindow;
        $newLines = [];
        
        foreach ($lines as $line) {
            $parts = explode('|', $line);
            if (count($parts) !== 2) {
                continue;
            }
            
            list($timestamp) = $parts;
            if ($timestamp > $cutoff) {
                $newLines[] = $line;
            }
        }
        
        if (!empty($newLines)) {
            file_put_contents($this->logFile, implode("\n", $newLines) . "\n", LOCK_EX);
        } else {
            file_put_contents($this->logFile, '', LOCK_EX);
        }
    }
    
    public function getRemainingTime($identifier) {
        if (!file_exists($this->logFile)) {
            return 0;
        }
        
        $lines = @file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return 0;
        }
        
        $cutoff = time() - $this->timeWindow;
        $oldestAttempt = null;
        
        foreach ($lines as $line) {
            $parts = explode('|', $line);
            if (count($parts) !== 2) {
                continue;
            }
            
            list($timestamp, $ip) = $parts;
            if ($ip === $identifier && $timestamp > $cutoff) {
                if ($oldestAttempt === null || $timestamp < $oldestAttempt) {
                    $oldestAttempt = $timestamp;
                }
            }
        }
        
        if ($oldestAttempt === null) {
            return 0;
        }
        
        return max(0, ($oldestAttempt + $this->timeWindow) - time());
    }
}
?>