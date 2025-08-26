<?php
/**
 * FPDF Wrapper with Proper Error Handling
 * This wrapper ensures FPDF is properly initialized and handles common errors
 */

require_once __DIR__ . '/fpdf/fpdf.php';

class SafeFPDF extends FPDF {
    
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4') {
        // Initialize FPDF the proper way (FPDF uses FPDF() method, not __construct)
        $this->FPDF($orientation, $unit, $size);
        
        // Double-check CoreFonts initialization
        if (!is_array($this->CoreFonts) || empty($this->CoreFonts)) {
            $this->CoreFonts = array('courier', 'helvetica', 'times', 'symbol', 'zapfdingbats');
        }
        
        // Ensure font path is set
        if (empty($this->fontpath)) {
            $this->fontpath = __DIR__ . '/fpdf/font/';
        }
    }
    
    public function SetFont($family, $style = '', $size = 0) {
        // Ensure CoreFonts is available before font operations
        if (!is_array($this->CoreFonts)) {
            $this->CoreFonts = array('courier', 'helvetica', 'times', 'symbol', 'zapfdingbats');
        }
        
        // Map common font names
        $fontMap = array(
            'arial' => 'helvetica',
            'times new roman' => 'times',
            'courier new' => 'courier'
        );
        
        $family = strtolower($family);
        if (isset($fontMap[$family])) {
            $family = $fontMap[$family];
        }
        
        try {
            parent::SetFont($family, $style, $size);
        } catch (Exception $e) {
            // Fallback to helvetica if font fails
            parent::SetFont('helvetica', $style, $size);
        }
    }
    
    public function AddPage($orientation = '', $size = '') {
        // Ensure page sizes are properly set
        if (!is_array($this->StdPageSizes)) {
            $this->StdPageSizes = array(
                'a3' => array(841.89,1190.55), 
                'a4' => array(595.28,841.89), 
                'a5' => array(420.94,595.28),
                'letter' => array(612,792), 
                'legal' => array(612,1008)
            );
        }
        
        try {
            parent::AddPage($orientation, $size);
        } catch (Exception $e) {
            // Fallback to default page
            parent::AddPage('P', 'A4');
        }
    }
}
?>
