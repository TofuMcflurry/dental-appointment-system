<div class="confirmation-modal" id="confirmationModal" style="display: none;">
  <div class="confirmation-card">
    <div class="confirmation-header">
      Appointment Receipt
    </div>

    <div class="confirmation-body">
      <div class="info-row">
        <span class="info-label">Mode of Payment</span>
        <span class="info-value">Cash</span>
      </div>

      <div class="info-row">
        <span class="info-label">Service Fee</span>
        <span class="info-value">₱1,500</span>
      </div>

      <div class="info-row">
        <span class="info-label">Duration / End Time</span>
        <span class="info-value" id="durationDisplay">1hr / 11:00 AM</span>
      </div>

      <div class="info-row">
        <span class="info-label">Status</span>
        <span class="info-value">Pending</span>
      </div>

      <div class="info-row">
        <span class="info-label">Branch</span>
        <span class="info-value">Main</span>
      </div>

      <div class="info-row">
        <span class="info-label">Ref. Number</span>
        <span class="info-value" style="font-family: monospace;" id="refNumber">APPT203090801</span>
      </div>

      <div class="checkbox-group">
        <input type="checkbox" id="termsCheckbox">
        <label for="termsCheckbox">Terms & Condition</label>
      </div>

      <div class="actions">
        <button class="btn btn-primary" id="confirmBookingBtn">Confirm Booking</button>
        <button class="btn btn-outline" id="cancelBookingBtn">Cancel</button>
      </div>
    </div>
  </div>
</div>

<style>
.confirmation-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.confirmation-card {
  background: #fff;
  width: 90%;
  max-width: 350px;
  border: 1px solid #c9c9c9;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.confirmation-header {
  border-bottom: 1px solid #ccc;
  text-align: center;
  padding: 10px;
  font-size: 1rem;
  font-weight: 600;
}

.confirmation-body {
  padding: 16px 18px;
}

.info-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 6px 0;
}

.info-label {
  font-weight: 500;
  color: #333;
  font-size: 0.85rem;
}

.info-value {
  font-weight: 600;
  color: #111;
  font-size: 0.85rem;
}

.payment-options {
  display: flex;
  justify-content: space-between;
  margin-top: 2px;
  font-size: 0.8rem;
}

.radio-group {
  display: flex;
  align-items: center;
  gap: 3px;
}

.checkbox-group {
  display: flex;
  align-items: center;
  gap: 6px;
  margin-top: 14px;
  font-size: 0.8rem;
}

.checkbox-group input[type="checkbox"] {
  width: 14px;
  height: 14px;
}

.actions {
  display: flex;
  justify-content: space-between;
  margin-top: 18px;
}

.btn {
  border: none;
  padding: 6px 20px;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s ease;
  font-size: 0.85rem;
}

.btn-primary {
  background: var(--nav);
  color: white;
}

.btn-primary:hover {
  background-color: #4c8df7;
}

.btn-outline {
  background-color: white;
  border: 1px solid #aaa;
  color: #222;
}

.btn-outline:hover {
  background-color: #f3f3f3;
}

@media (max-width: 400px) {
  .info-row {
    flex-direction: column;
    align-items: flex-start;
  }

  .actions {
    flex-direction: column;
    gap: 8px;
  }

  .btn {
    width: 100%;
  }
}
</style>