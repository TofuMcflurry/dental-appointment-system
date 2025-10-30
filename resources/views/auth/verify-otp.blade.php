@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="otp-verification-container">
    <div class="otp-card">
        <div class="otp-header">
            <h2>Verify Your Identity</h2>
            <p>Enter the verification code sent to your email</p>
        </div>

        <div class="otp-email-info">
            <strong>📧 {{ auth()->user()->email }}</strong>
        </div>

        <form id="verifyOtpForm" class="otp-form">
            @csrf
            
            <div class="form-group">
                <label for="otp_code">6-Digit Verification Code</label>
                <input type="text" 
                       id="otp_code" 
                       name="otp_code" 
                       class="otp-input"
                       maxlength="6"
                       placeholder="000000"
                       required
                       autofocus>
                <div id="otpError" class="error-message" style="display: none;"></div>
            </div>

            <div class="timer-section">
                <p>Code expires in: <span id="countdown" class="timer">15:00</span></p>
            </div>

            <div class="otp-actions">
                <button type="submit" class="btn btn-primary" id="verifyBtn">Verify & Change Password</button>
                <button type="button" id="resendOtp" class="btn btn-secondary">Resend Code</button>
                <a href="{{ route('patient.settings') }}" class="btn btn-link">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.otp-verification-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 60vh;
    padding: 20px;
}

.otp-card {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    max-width: 400px;
    width: 100%;
}

.otp-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.otp-header h2 {
    color: var(--accent);
    margin-bottom: 0.5rem;
}

.otp-email-info {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 6px;
    text-align: center;
    margin-bottom: 1.5rem;
    border-left: 4px solid var(--nav);
}

.otp-input {
    font-size: 1.5rem;
    text-align: center;
    letter-spacing: 0.5rem;
    padding: 1rem;
    font-weight: bold;
    border: 2px solid #ddd;
    border-radius: 8px;
    width: 100%;
}

.otp-input:focus {
    border-color: var(--nav);
    outline: none;
}

.timer-section {
    text-align: center;
    margin: 1rem 0;
}

.timer {
    font-weight: bold;
    color: #dc3545;
}

.otp-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.btn-link {
    text-align: center;
    text-decoration: none;
    color: #666;
}

.error-message {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}
</style>
@endpush

@push('scripts')
<script>
// ✅ PASTE THE ENTIRE JAVASCRIPT CODE HERE - REPLACE WHATEVER WAS THERE BEFORE
document.addEventListener('DOMContentLoaded', function() {
    const countdownElement = document.getElementById('countdown');
    const otpInput = document.getElementById('otp_code');
    const resendBtn = document.getElementById('resendOtp');
    const verifyForm = document.getElementById('verifyOtpForm');
    const verifyBtn = document.getElementById('verifyBtn');
    const otpError = document.getElementById('otpError');
    let timeLeft = 15 * 60;

    // Countdown timer
    function updateCountdown() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        countdownElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        if (timeLeft <= 0) {
            countdownElement.textContent = 'Expired!';
            countdownElement.style.color = '#dc3545';
            otpInput.disabled = true;
            verifyBtn.disabled = true;
        } else {
            timeLeft--;
            setTimeout(updateCountdown, 1000);
        }
    }

    updateCountdown();

    // Form submission
    verifyForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const otpCode = otpInput.value.trim();
        
        if (otpCode.length !== 6) {
            showError('Please enter a 6-digit code');
            return;
        }

        // Show loading state
        verifyBtn.textContent = 'Verifying...';
        verifyBtn.disabled = true;
        hideError();

        // Submit via AJAX
        fetch('{{ route("patient.verify.otp.submit") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ otp_code: otpCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    window.location.href = '{{ route("patient.settings") }}';
                }
            } else {
                showError(data.message);
                otpInput.value = '';
                otpInput.focus();
                verifyBtn.textContent = 'Verify & Change Password';
                verifyBtn.disabled = false;
            }
        })
        .catch(error => {
            showError('Network error. Please try again.');
            verifyBtn.textContent = 'Verify & Change Password';
            verifyBtn.disabled = false;
        });
    });

    // Auto-submit when 6 digits are entered
    otpInput.addEventListener('input', function(e) {
        // Remove non-digit characters
        this.value = this.value.replace(/\D/g, '');
        hideError();
        
        if (this.value.length === 6) {
            verifyForm.dispatchEvent(new Event('submit'));
        }
    });

    // Resend OTP
    resendBtn.addEventListener('click', function() {
        if (confirm('Send new verification code to your email?')) {
            fetch('{{ route("patient.resend.otp") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    // Reset timer and form
                    timeLeft = 15 * 60;
                    updateCountdown();
                    otpInput.disabled = false;
                    otpInput.value = '';
                    otpInput.focus();
                    verifyBtn.disabled = false;
                    verifyBtn.textContent = 'Verify & Change Password';
                    hideError();
                } else {
                    alert('❌ ' + data.message);
                }
            });
        }
    });

    function showError(message) {
        otpError.textContent = message;
        otpError.style.display = 'block';
    }

    function hideError() {
        otpError.style.display = 'none';
    }
});
</script>
@endpush