import React, { useState, useEffect, useRef } from 'react';
import { Head } from '@inertiajs/react';
import axios from 'axios';

export default function Results({ sessionId }) {
    const [status, setStatus] = useState('generating');
    const [roomData, setRoomData] = useState(null);
    const [error, setError] = useState(null);
    const [isLightboxOpen, setIsLightboxOpen] = useState(false);
    
    // Option B Refinement State
    const [revisionPrompt, setRevisionPrompt] = useState('');
    const [isRevising, setIsRevising] = useState(false);
    const [revisionMessage, setRevisionMessage] = useState('');
    
    // Toggle for 3-component breakdown vs summary-only
    const [showComponentBreakdown, setShowComponentBreakdown] = useState(false);

    const pollIntervalRef = useRef(null);

    const startPolling = () => {
        if (pollIntervalRef.current) {
            clearInterval(pollIntervalRef.current);
        }

        let attempts = 0;

        const checkStatus = async () => {
            attempts++;
            try {
                const { data } = await axios.get(`/api/v1/rooms/${sessionId}/status`);
                
                if (data.status === 'failed') {
                    setStatus('failed');
                    setIsRevising(false);
                    if (pollIntervalRef.current) clearInterval(pollIntervalRef.current);
                    return;
                }

                if (data.status === 'completed' && data.has_personality_profile) {
                    if (pollIntervalRef.current) clearInterval(pollIntervalRef.current);
                    await fetchFullData();
                } else if (data.status === 'completed' && attempts >= 8) {
                    if (pollIntervalRef.current) clearInterval(pollIntervalRef.current);
                    await fetchFullData();
                } else {
                    setStatus(data.status);
                }
            } catch (err) {
                console.error('Error fetching room status:', err);
                if (attempts >= 40) {
                    setError('Connection lost while checking room status. Please refresh.');
                    setIsRevising(false);
                    if (pollIntervalRef.current) clearInterval(pollIntervalRef.current);
                }
            }
        };

        pollIntervalRef.current = setInterval(checkStatus, 2500);
        checkStatus();
    };

    const fetchFullData = async () => {
        try {
            const { data } = await axios.get(`/api/v1/rooms/${sessionId}`);
            setRoomData(data);
            setStatus('completed');
            setIsRevising(false);
            setRevisionMessage('');
        } catch (err) {
            console.error('Error fetching room data:', err);
            setError('Failed to load room details. Please try refreshing.');
            setIsRevising(false);
        }
    };

    useEffect(() => {
        startPolling();
        return () => {
            if (pollIntervalRef.current) clearInterval(pollIntervalRef.current);
        };
    }, [sessionId]);

    const handleRevise = async (e) => {
        e.preventDefault();
        const text = revisionPrompt.trim();
        if (!text || isRevising) return;

        setIsRevising(true);
        setRevisionMessage(`Applying revision: "${text}"...`);

        try {
            await axios.post(`/api/v1/rooms/${sessionId}/revise`, { prompt: text });
            setRevisionPrompt('');
            setStatus('generating');
            startPolling();
        } catch (err) {
            console.error('Error submitting revision:', err);
            setRevisionMessage('Failed to submit revision. Please try again.');
            setIsRevising(false);
        }
    };

    if (error || status === 'failed') {
        return (
            <div className="container" style={{ textAlign: 'center', paddingTop: '10vh' }}>
                <Head title="Error | HavenIQ" />
                <h1 className="title" style={{ color: 'var(--error-color)' }}>Generation Failed</h1>
                <p className="subtitle">{error || 'We encountered an unexpected issue while generating your room. Please try again.'}</p>
                <button className="btn btn-primary" onClick={() => window.location.href = '/'} style={{ marginTop: '2rem' }}>
                    Start Over
                </button>
            </div>
        );
    }

    if (status !== 'completed' || !roomData) {
        return (
            <div className="container" style={{ textAlign: 'center', paddingTop: '10vh' }}>
                <Head title="Generating... | HavenIQ" />
                <div className="loader"></div>
                <h2 className="title" style={{ fontSize: '2rem', marginTop: '2rem' }}>
                    {isRevising ? 'Revising Your Space' : 'Visualizing Your Space'}
                </h2>
                <p className="subtitle">
                    {isRevising 
                        ? (revisionMessage || 'Our AI is regenerating your architectural render and updating your profile...')
                        : 'Our AI is generating an architectural render and analyzing your cognitive orientation...'}
                </p>
                <div className="progress-container" style={{ maxWidth: '400px', margin: '2rem auto' }}>
                    <div className="progress-fill loader-bar"></div>
                </div>
            </div>
        );
    }

    const { image_url, personality_profile } = roomData;
    const cleanImageUrl = image_url ? image_url.replace(/^http:\/\/localhost(?::\d+)?\/storage/, '/storage') : '/presets/warm_modern.jpg';

    const handleDownload = () => {
        const link = document.createElement('a');
        link.href = cleanImageUrl;
        link.download = `haveniq-${sessionId}.webp`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };

    return (
        <div className="results-container">
            <Head title="Your Haven Results | HavenIQ" />
            
            <header className="header" style={{ marginBottom: '2.5rem' }}>
                <h1 className="title">Your Haven</h1>
                <p className="subtitle">A visual and psychological reflection of your personal aesthetic.</p>
            </header>

            {/* Featured Hero Architectural Showcase */}
            <div className="hero-showcase">
                <div className="image-badge">
                    <span>✨</span> FLUX 2 Pro Architectural Visualization
                </div>
                
                <div className="hero-image-wrapper">
                    <img 
                        src={cleanImageUrl} 
                        alt="Generated Architectural Space" 
                        className="hero-image"
                        onClick={() => setIsLightboxOpen(true)}
                        onError={(e) => {
                            e.target.onerror = null;
                            e.target.src = '/presets/warm_modern.jpg';
                        }} 
                    />
                </div>

                <div className="image-actions">
                    <button className="action-pill" onClick={() => setIsLightboxOpen(true)} title="Expand Fullscreen">
                        🔍 View Fullscreen
                    </button>
                    <button className="action-pill" onClick={handleDownload} title="Download Render">
                        📥 Download Render
                    </button>
                </div>

                {/* Option B: Direct AI Refinement Box */}
                <div className="refine-card">
                    <div className="refine-header">
                        <span className="refine-icon">✏️</span>
                        <div>
                            <h3 className="refine-title">Revise This Room</h3>
                            <p className="refine-subtitle">
                                Want to adjust the image? Describe your tweak (e.g., <em>"Make wall 1 sage green"</em>, <em>"Only show one wall clock"</em>, <em>"Add warmer ambient lighting"</em>).
                            </p>
                        </div>
                    </div>
                    <form onSubmit={handleRevise} className="refine-form">
                        <input
                            type="text"
                            value={revisionPrompt}
                            onChange={(e) => setRevisionPrompt(e.target.value)}
                            placeholder="Describe your tweak for this room..."
                            className="refine-input"
                            disabled={isRevising}
                        />
                        <button 
                            type="submit" 
                            className="btn btn-primary refine-btn" 
                            disabled={isRevising || !revisionPrompt.trim()}
                        >
                            {isRevising ? 'Revising...' : 'Revise Render ✨'}
                        </button>
                    </form>
                    {revisionMessage && (
                        <div className="refine-status-pill">
                            <span>✦</span> {revisionMessage}
                        </div>
                    )}
                </div>
            </div>

            {/* Personality & Character Profile Section */}
            <section className="personality-section">
                <div className="section-header">
                    <h2 className="section-title">Personality & Character Profile</h2>
                    <p className="section-subtitle">Defining your personality and primary character traits through your living space.</p>
                </div>

                {/* Primary 3-Paragraph Summary Narrative (Summary-Only Display) */}
                {personality_profile?.summary ? (
                    <div className="summary-card" style={{ marginTop: '1.5rem' }}>
                        <h3 className="summary-title">
                            <span>✦</span> Character Profile Summary
                        </h3>
                        <div className="summary-body" style={{ whiteSpace: 'pre-line' }}>
                            {personality_profile.summary}
                        </div>
                    </div>
                ) : (
                    <div className="glass-card" style={{ padding: '2rem', textAlign: 'center', color: 'var(--text-secondary)', marginBottom: '2rem' }}>
                        <p>Personality profile is being finalized...</p>
                    </div>
                )}

                {/* Optional Component Breakdown Toggle */}
                {personality_profile?.traits && personality_profile.traits.length > 0 && (
                    <div style={{ marginTop: '2rem', textAlign: 'center' }}>
                        <button 
                            type="button"
                            onClick={() => setShowComponentBreakdown(!showComponentBreakdown)}
                            className="action-pill"
                            style={{ margin: '0 auto', fontSize: '0.9rem', padding: '0.6rem 1.2rem' }}
                        >
                            {showComponentBreakdown ? '▲ Hide Trait Breakdown' : '▼ View 3-Trait Breakdown'}
                        </button>

                        {showComponentBreakdown && (
                            <div className="traits-grid" style={{ marginTop: '1.5rem' }}>
                                {personality_profile.traits.map((trait, index) => (
                                    <div key={index} className="trait-card">
                                        <div className="trait-header">
                                            <h3 className="trait-name">{trait.name}</h3>
                                            <span className="trait-score">{trait.score}% Prominence</span>
                                        </div>
                                        {trait.anchor && (
                                            <span className="trait-anchor-tag">
                                                ✦ Feature: {trait.anchor}
                                            </span>
                                        )}
                                        <p className="trait-explanation">{trait.explanation}</p>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                )}
            </section>

            {/* Action Bar */}
            <div style={{ display: 'flex', justifyContent: 'center', gap: '1rem', marginTop: '3.5rem', flexWrap: 'wrap' }}>
                <button className="btn btn-primary" onClick={() => window.location.href = '/'}>
                    Design Another Space
                </button>
                <button className="btn btn-secondary" onClick={handleDownload}>
                    Download Architectural Render
                </button>
            </div>

            {/* Lightbox Modal */}
            {isLightboxOpen && (
                <div className="lightbox-overlay" onClick={() => setIsLightboxOpen(false)}>
                    <div className="lightbox-content" onClick={(e) => e.stopPropagation()}>
                        <button className="lightbox-close" onClick={() => setIsLightboxOpen(false)} title="Close">
                            ✕
                        </button>
                        <img src={cleanImageUrl} alt="Full resolution render" className="lightbox-image" />
                    </div>
                </div>
            )}
        </div>
    );
}
